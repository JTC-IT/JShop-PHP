<?php

function addItem($ds, $item = []){
    if(is_array($item) && count($item) > 1){
        $len_cart = 0;
        if(is_array($ds)){
            $len_cart = count($ds);
            for ($i = 0; $i < $len_cart; $i++) {
                if($ds[$i]['id'] == $item['id']){
                    $ds[$i]['quantity'] += $item['quantity'];
                    if($ds[$i]['quantity'] > 9)
                        $ds[$i]['quantity'] = 9;
                    return $ds;
                }
            }
        } else $ds = [];
        $ds[$len_cart] = $item;
    }
    return $ds;
}

function removeItem($list, $id){
    if(is_array($list) && is_numeric($id)){
        $len_cart = count($list);
        for ($i = 0; $i < $len_cart; $i++)
            if($list[$i]['id'] == $id){
                unset($list[$i]);
                return $list;
            }
    }
    return $list;
}

function changeQuantity($list, $id, $quantity){
    if(is_array($list) && is_numeric($id) && is_numeric($quantity)){
        $len_cart = count($list);
        for ($i = 0; $i < $len_cart; $i++)
            if($list[$i]['id'] == $id){
                $list[$i]['quantity'] = $quantity;
                return $list;
            }
    }
    return $list;
}

function getTotalQuantity($list){
    if(!is_array($list))
        return 0;
    $total = 0;
    foreach ($list as $item) {
        $total += (int) $item['quantity'];
    }
    return $total;
}

function getThanhTienByItem($list, $id)
{
    $sum = 0;
    if(is_array($list))
        foreach ($list as $item) {
            if($item['id'] == $id){
                $sum = (int) $item['price']*$item['quantity'];
                break;
            }
        }
    return number_format($sum).' đ';
}

function getThanhTien($list)
{
    $sum = 0;
    if(is_array($list))
        foreach ($list as $item) {
            $sum += (int) $item['price']*$item['quantity'];
        }
    return number_format($sum).' đ';
}