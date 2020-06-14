<?php

namespace App\Extensions;

use Illuminate\Database\Eloquent\Collection;
use KubAT\PhpSimple\HtmlDomParser;
use simple_html_dom\simple_html_dom_node;

class ComparisonExtension
{
    protected static $skip_specification = ['Краткие характеристики'];
    protected static $all_specification = [];
    protected static $final_data = [];

    public static function create(Collection $products)
    {
        self::setAllSpecification($products);

        self::setValueSpecification($products);

        self::uniteData($products);

        return self::$final_data;
    }

    protected static function setAllSpecification(Collection $products)
    {
        foreach ($products as $product) {

            $html = HtmlDomParser::str_get_html($product->big_specifications);

            foreach ($html->find('p') as $p) {
                $b = $p->find('b', 0);

                $name_specification = self::getNameSpecification($b);

                if (!in_array($name_specification, self::$all_specification) && !in_array($name_specification, self::$skip_specification)) {
                    self::$all_specification[] = $name_specification;
                }
            }
        }
        unset($html);
    }

    protected static function setValueSpecification(Collection $products)
    {
        foreach ($products as $product) {

            $html = HtmlDomParser::str_get_html($product->big_specifications);

            foreach ($html->find('p') as $p) {

                $b = $p->find('b', 0);

                $name_specification = self::getNameSpecification($b);
                $value_specification = self::getValueSpecification($p);

                if (in_array($name_specification, self::$all_specification)) {
                    self::$final_data[$name_specification][$product->id] = $value_specification;
                }
            }
        }
        unset($html);
    }

    protected static function uniteData(Collection $products)
    {
        foreach ($products as $product) {

            foreach (self::$final_data as $name_specification => &$value_specification) {

                if (!array_key_exists($product->id, $value_specification)) {
                    $value_specification[$product->id] = '&mdash;';
                    self::$final_data[$name_specification] = $value_specification;
                }

                ksort($value_specification);
            }
        }
    }

    protected static function getNameSpecification(simple_html_dom_node $dom)
    {
        return trim(trim($dom->innertext), '&nbsp;');
    }

    protected static function getValueSpecification(simple_html_dom_node $dom)
    {
        return trim(trim(preg_replace('#<b>.*</b>#', '', $dom->innertext), '&nbsp;'));
    }

}
