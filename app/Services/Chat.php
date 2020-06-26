<?php

namespace App\Services;

use App\Models\Chat as Model;
use App\Extensions\ChatProvider;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;


class Chat
{
    protected $provider;
    protected $file_hash;

    public function __construct(ChatProvider $provider, $file_hash = null)
    {
        $this->provider = $provider;
        $this->file_hash = $file_hash;
    }

    public function addMessage(Request $request)
    {
        if (!$request->filled(['hash', 'message', 'user_name'])) {
            return null;
        }

        $data = $request->only(['hash', 'message', 'user_name']);

        $file_path = $this->provider->getFilePath($data['hash']);

        $this->provider->newMessage($file_path, $data['user_name'], $data['message']);
    }

    public function push($user_name, $message)
    {

    }

    public function createChat($user_name, $message) : string
    {
        $hash = $this->createNameFile();

        if ($file_name = $this->provider->make($hash, $user_name)) {
            $this->provider->addMessage($file_name, $user_name, $message);
        }

        return $hash;
    }

    protected function createNameFile()
    {
        $hash = md5(mt_rand(1111, 9999));

        if (Model::where('hash', $hash)->exists()) {
            return $this->createNameFile();
        }

        return $hash;
    }

    public function getForAdminWithNew($admin_id) : Collection
    {
        $result_new_chats = collect();
        $result_admin_chats = collect();

        $new_chats = collect($this->provider->getNew());

        if ($new_chats->isNotEmpty()) {
            $result_new_chats = $new_chats->mapWithKeys(function ($item) {
                return [$this->getHash($item) => $this->createDataForList($item)];
            });
        }

        $admin_chats = collect($this->provider->getForAdmin($admin_id));

        if ($admin_chats->isNotEmpty()) {
            $result_admin_chats = $admin_chats->mapWithKeys(function ($item) {
                return [$this->getHash($item) => $this->createDataForList($item)];
            });
        }

        return $result_new_chats->merge($result_admin_chats);
    }

    protected function getHash($file_name)
    {
        $ext = $this->provider::FILE_EXT;
        $pattern = "#/\S+/(?<hash>\S+){$ext}#";
        preg_match($pattern, $file_name, $math);

        if (!empty($math)) {
            return $math['hash'];
        }

        return null;
    }

    protected function createDataForList($file_chat_path)
    {
        $result = $this->provider->getDataChat($file_chat_path);

        $result['first_message'] = $result['messages']->first()['message'];

        return $result;
    }

    public function get($hash)
    {
        switch ($this->getTypeChat($hash)) {
            case (1):
                $file_path = $this->provider->getPathNewChats($hash);
                break;

            case (2):
                $file_path = $this->provider->getPathConnectedChat($hash);
                break;

            default:
                return;
        }

        $chat = $this->provider->getDataChat($file_path);

        $chat['messages'] = $chat['messages']->transform(function ($item) {
            $item['is_admin'] = ($item['user_name'] == 'admin');
            return $item;
        });

        return $chat;
    }

    protected function getTypeChat($hash) : int
    {
        if ($this->provider->isNew($hash)) {
            return 1;
        }

        if ($this->provider->isConnected($hash)) {
            return 2;
        }

        return 0;
    }

    protected function isAdminMessage(string $message_data)
    {
        $array_message_data = $this->provider->parseMessage($message_data);
        $user = $array_message_data['user_name'];

        return ($user == 'admin') ? true : false;
    }
}
