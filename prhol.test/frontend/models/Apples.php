<?php


namespace frontend\models;


use Yii;

class Apples
{
    private $generation_id;
    private $shape_radius = 50; // config

    private $time_offset_new_generation_element; // = 3600; // config;
    private $length_generation_id; // = 11; // config;

    private $width_content = 1200; // config;
    private $height_content = 800; // config;
    private $offset_distanse_between_items; // = 10; // config;

    private $unit; // = 30; // config; // count*unit = hour   like a 360 sec = hour
    private $time_to_disappearance; // = 5; // config; // hours
    private $count_apples; // = 53; // config; // hours

    public function __construct()
    {
        $this->generation_id = $this->generateGenerationId();

        $params = $this->getParams();

        $this->count_apples = $params['count_apples'];
        $this->time_to_disappearance = $params['time_to_disappearance'];
        $this->unit = $params['unit'];
        $this->offset_distanse_between_items = $params['offset_distanse_between_items'];
        $this->length_generation_id = $params['length_generation_id'];
        $this->time_offset_new_generation_element = $params['time_offset_new_generation_element'];
    }

    public function getParams($param_id = 1)
    {

        $sql = "
        SELECT count_apples, time_to_disappearance, unit, offset_distanse_between_items, length_generation_id, time_offset_new_generation_element 
        FROM params 
        WHERE params.id=:id 
        LIMIT 1";

        $params = Yii::$app->db->createCommand($sql)
            ->bindValue(':id', $param_id)
            ->queryOne();

        if (empty($params)) {
            $params_valid = [
                'count_apples' => 53,
                'time_to_disappearance' => 5,
                'unit' => 30,
                'offset_distanse_between_items' => 10,
                'length_generation_id' => 11,
                'time_offset_new_generation_element' => 3600
            ];
        } else {

            if ($params['count_apples'] < 10) {
                $params_valid['count_apples'] = 10;
            } else {
                $params_valid['count_apples'] = $params['count_apples'];
            }
            if ($params['count_apples'] > 100) {
                $params_valid['count_apples'] = 100;
            } else {
                $params_valid['count_apples'] = $params['count_apples'];
            }

            if ($params['time_to_disappearance'] < 5) {
                $params_valid['time_to_disappearance'] = 5;
            } else {
                $params_valid['time_to_disappearance'] = $params['time_to_disappearance'];
            }
            if ($params['time_to_disappearance'] > 100) {
                $params_valid['time_to_disappearance'] = 100;
            } else {
                $params_valid['time_to_disappearance'] = $params['time_to_disappearance'];
            }

            if ($params['unit'] < 10) {
                $params_valid['unit'] = 10;
            } else {
                $params_valid['unit'] = $params['unit'];
            }
            if ($params['unit'] > 1000) {
                $params_valid['unit'] = 1000;
            } else {
                $params_valid['unit'] = $params['unit'];
            }

            if ($params['offset_distanse_between_items'] < 10) {
                $params_valid['offset_distanse_between_items'] = 10;
            } else {
                $params_valid['offset_distanse_between_items'] = $params['offset_distanse_between_items'];
            }
            if ($params['offset_distanse_between_items'] > 12) {
                $params_valid['offset_distanse_between_items'] = 12;
            } else {
                $params_valid['offset_distanse_between_items'] = $params['offset_distanse_between_items'];
            }

            if ($params['time_offset_new_generation_element'] < 10) {
                $params_valid['time_offset_new_generation_element'] = 10;
            } else {
                $params_valid['time_offset_new_generation_element'] = $params['time_offset_new_generation_element'];
            }
            if ($params['time_offset_new_generation_element'] > 5000) {
                $params_valid['time_offset_new_generation_element'] = 5000;
            } else {
                $params_valid['time_offset_new_generation_element'] = $params['time_offset_new_generation_element'];
            }

            $params_valid['length_generation_id'] = 11;
        }
        return $params_valid;
    }


    public function getMaxCount()
    {
        $shape_radius = $this->shape_radius;
        $width_content = $this->width_content;
        $height_content = $this->height_content;

        return 100;
    }

    public function getPositions($count)
    {
        if ($count > $this->getMaxCount()) $count = $this->getMaxCount();

        $shape_radius = $this->shape_radius;
        $width_content = $this->width_content;
        $height_content = $this->height_content;

        $positions = [];
        $pos_left = 0;
        $pos_top = 0;

        $pos_offset = $shape_radius + $this->offset_distanse_between_items;

        $i = 0;
        $count_row = 0;
        while ($i < $count) {
            if ($pos_left > ($width_content - $pos_offset)) {
                $count_row = 0;
                $pos_left = 0;
                $pos_top += $pos_offset;
            }

            $positions[] = [
                'left' => $pos_left,
                'top' => $pos_top,
            ];
            $i++;
            $count_row++;
            $pos_left = $count_row * $pos_offset;
        }

        return $positions;
    }

    function getTimeOffset($time_start)
    {
        // check dublicate
        return $time_start + random_int(0, $this->time_offset_new_generation_element);
    }

    public function generateGenerationId()
    {
        // check dublicate
        //if ($length < 11) $length = 11;
        $min = "1" . str_pad('', $this->length_generation_id, "0", STR_PAD_RIGHT);
        $max = "9" . str_pad('', $this->length_generation_id, "9", STR_PAD_RIGHT);
        $random_int = random_int(intval($min), intval($max));
        return $random_int;
    }

    public function listColors()
    {
        return [
            'green',
            'red',
            'orange',
            'goldenrod',
            'chartreuse',
            'gold',
            'greenyellow',
            'khaki',
            'indianred',
            'lawngreen',
        ];
    }

    public function getRandomElementFromSimpleList($list)
    {
        if (empty($list)) return [];
        $id = random_int(1, sizeof($list) - 1);
        return [
            'id' => $id,
            'value' => $list[$id]
        ];
    }

    public function createItemData($left, $top)
    {
        $date_appearance = (int)$this->getTimeOffset(time());
        $params = [
            'generation_id' => $this->generation_id,
            'id' => $this->generation_id . "_" . $date_appearance,
            'color' => $this->getRandomElementFromSimpleList($this->listColors())['value'],
            'size' => 100,
            'date_appearance' => $date_appearance,
            'date_fall' => 0,
            'date_disappearance' => 0,
            'reason' => 0,
            'status' => 0,
            'left' => $left,
            'top' => $top,
        ];
        return $params;
    }

    public function getItemsForm($params, $i)
    {
        $itemForm[] = '<div id="';
        $itemForm[] = $params['id'];
        $itemForm[] = '" ';

        $itemForm[] = ' attr-order="';
        $itemForm[] = $i;
        $itemForm[] = '" ';

        $itemForm[] = ' class="round apple_form"';

        $itemForm[] = ' style="top:';
        $itemForm[] = $params['top'];
        $itemForm[] = 'px;left:';
        $itemForm[] = $params['left'];
        $itemForm[] = 'px;';

        $itemForm[] = 'background-color:';
        $itemForm[] = $params['color'];
        $itemForm[] = ';';

        $itemForm[] = '" ';

        $itemForm[] = '></div>';

        return implode('', $itemForm);
    }

    // <div id="553078308918_1587856620" class="round apple_form" style="top:px;left:px;background-color:Array;" <="" div="">

    public function createItemsData()
    {
        $count = $this->count_apples;
        $items = [];
        $content = [];

        if ($count != 0) {
            $i = 0;
            $positions = $this->getPositions($count);
            while ($i < $count) {
                $left = $positions[$i]['left'];
                $top = $positions[$i]['top'];
                $params = $this->createItemData($left, $top);
                $items[$i] = $params;
                $content[] = $this->getItemsForm($params, $i);
                $i++;
            }
        }

        return [
            'items_data' => json_encode($items, JSON_UNESCAPED_UNICODE),
            'content' => implode('', $content),
            'width_content' => $this->width_content,
            'height_content' => $this->height_content,
            'time_to_disappearance' => $this->time_to_disappearance, // * $this->unit,
            'unit' => $this->unit,
            'generation_id' => $this->generation_id,
        ];
    }


    /* -------------- */

    public function setStatusPosition()
    {
        //$this->status = ['id'=];
    }

    public function getStatusPosition()
    {

    }

    function appleFall($apple_id)
    {

    }

    function appleEat($percent)
    {

    }

    function appleRemove()
    {

    }

    /*
timetick
zoom time

apple_age

    state_hanging_on_a_tree
state_fell
state_rotten
    */

}