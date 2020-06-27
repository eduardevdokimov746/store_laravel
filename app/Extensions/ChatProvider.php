<?php

namespace App\Extensions;

use Carbon\Carbon;

class ChatProvider
{
    protected $base_folder = 'chats';
    protected $folder_admin_chats = 'connected';
    protected $folder_name_new_chats = 'new';
    protected $storage_disk = 'local';
    public const FILE_EXT = '.txt';
    protected $path_admin_chats;
    protected $path_new_chats;
    protected $delimiter = '#|&';

    public function __construct()
    {
        $this->path_admin_chats = $this->base_folder . '/' . $this->folder_admin_chats;
        $this->path_new_chats = $this->base_folder . '/' . $this->folder_name_new_chats;
    }

    public function getNew()
    {
        return \Storage::disk($this->storage_disk)->allFiles($this->path_new_chats);
    }

    public function make($hash, $user_name)
    {
        $headers = $this->getHeader($user_name);
        $file_path = $this->getPathNewChats($hash);
        $this->getStorage()->put($file_path, $headers);

        return $file_path;
    }

    protected function getHeader($user_name)
    {
        $result = Carbon::now() . "\r\n" . $user_name . "\r\n";

        return $result;
    }

    public function getPathNewChats($hash)
    {
        return $this->path_new_chats . '/' . $hash . self::FILE_EXT;
    }

    public function createPathConnectedChat($admin_id, $hash)
    {
        return $this->path_admin_chats . '/' . $admin_id . '/' . $hash . self::FILE_EXT;
    }

    public function getPathConnectedChat($hash)
    {
        foreach ($this->getConnectedFilesPath() as $file_path) {
            if (strpos($file_path, $hash) !== false) {
                return $file_path;
            }
        }

        return null;
    }

    public function getDataChat($file_chat_path)
    {
        $file = $this->getStorage()->get($file_chat_path);

        $data = explode("\r\n\r\n", $file);

        $header = explode("\r\n", $data[0]);

        $messages = collect(explode("\r\n", $data[1]));

        $result['created_at'] = $header[0];
        $result['user_name'] = $header[1];
        $result['status'] = $this->isNewFilePath($file_chat_path);

        $result['messages'] = $messages->map(function ($item) {
            return $this->parseMessage($item);
        });

        $result['hash'] = $this->getHash($file_chat_path);
        return $result;
    }

    public function parseMessage(string $message) : array
    {
        $data = explode($this->delimiter, $message);

        $result['user_name'] = $data[0];
        $result['message'] = $data[1];
        $result['created_at'] = $data[2];

        return $result;
    }

    public function isNewFilePath($file_chat_path)
    {
        return $this->isNew($this->getHash($file_chat_path));
    }

    public function getForAdmin($admin_id)
    {
        $folder_path = $this->path_admin_chats . '/' . $admin_id;

        return $this->getStorage()->allFiles($folder_path);
    }

    public function addMessage($file_name, $user_name, $message)
    {
        $message = $this->createMessage($user_name, $message);

        $this->getStorage()->append($file_name, $message);
    }

    protected function createMessage($user_name, $message) : string
    {
        $data[] = $user_name;
        $data[] = $message;
        $data[] = Carbon::now('Europe/Moscow');

        return implode($this->delimiter, $data);
    }

    protected function getStorage()
    {
        return \Storage::disk($this->storage_disk);
    }

    public function getHash($file_path)
    {
        $result = $file_path;

        if (strpos($file_path, '/') !== false) {
            preg_match("#\S+\/\S+\/(?<match>\S+)#", $file_path, $match);
            $result = $match['match'];
        }

        if (strpos($file_path, '.') !== false) {
            preg_match("#(?<match>\S+)\.\S+#", $result, $match);
            $result = $match['match'];
        }

        return $result;
    }

    public function isNew($hash)
    {
        foreach ($this->getNewFilesPath() as $file_path) {
            if (strpos($file_path, $hash) !== false) {
                return true;
            }
        }

        return false;
    }

    public function isConnected($hash)
    {
        foreach ($this->getConnectedFilesPath() as $file_path) {
            if (strpos($file_path, $hash) !== false) {
                return true;
            }
        }

        return false;
    }

    protected function getNewFilesPath() : array
    {
        return $this->getStorage()->files($this->path_new_chats);
    }

    protected function getConnectedFilesPath() : array
    {
        return $this->getStorage()->allFiles($this->path_admin_chats);
    }

    public function newMessage($file_path, $user_name, $message)
    {
        $message_data = $this->createMessage($user_name, $message);

        $this->getStorage()->append($file_path, $message_data);
    }

    public function getFilePath($hash)
    {
        if ($this->isNew($hash)) {
            return $this->getPathNewChats($hash);
        }

        if ($this->isConnected($hash)) {
            return $this->getPathConnectedChat($hash);
        }

        return null;
    }

    public function moveNewChat($admin_id, $hash)
    {
        $file_old_path = $this->getPathNewChats($hash);
        $file_new_path = $this->createPathConnectedChat($admin_id, $hash);

        return $this->getStorage()->move($file_old_path, $file_new_path);
    }
}
