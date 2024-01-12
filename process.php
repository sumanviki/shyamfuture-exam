<?php

//print_r($_FILES);
//print_r($_POST);
session_start();
/*session_destroy();
exit();*/


if(isset($_POST['sendData']))
{

    $dataGet = $_POST['sendData'];
    $mode = $dataGet['mode'];
    $key = $dataGet['id'];

    if($mode == 'view')
    {

        $data = $_SESSION['user'][$key];
        $response = array();
        $response['name'] = $data['name'];
        $response['image'] = $data['image'];
        $response['address'] = $data['address'];
        $response['gender'] = $data['gender'];
        
        echo json_encode($response);
        exit();
    }
    elseif($mode == 'edit')
    {
        $data = $_SESSION['user'][$key];
        $response = array();
        $response['key'] = $key;
        $response['name'] = $data['name'];
        $response['image'] = $data['image'];
        $response['address'] = $data['address'];
        $response['gender'] = $data['gender'];
        
        echo json_encode($response);
        exit();
    }
    

}
else
{
    
    if($_POST['key_id']!='')
    {
        $key = $_POST['key_id'];
        $data = $_SESSION['user'][$key];
        if (isset($_POST['name']))
        {
            $data['name'] = $_POST['name'];
        }
        if (isset($_FILES['image']['tmp_name']))
        {
            $filename = $_FILES["image"]["name"];
            $tempname = $_FILES["image"]["tmp_name"];
            $folder = "profile/" . $filename;
            if (move_uploaded_file($tempname, $folder)) {
                $data['image'] = $folder;
            }
        }
        if (isset($_POST['address']))
        {
            $data['address'] =  $_POST['address'];
        }
        
        if (isset($_POST['gender']))
        {
            $data['gender'] =  $_POST['gender'];
        }


        $_SESSION['user'][$key] = $data;
    }
    else
    {

        $data=array();
        if (isset($_POST['name']))
        {
            $data['name'] = $_POST['name'];
        }

        if (isset($_FILES['image']['tmp_name']))
        {
            $filename = $_FILES["image"]["name"];
            $tempname = $_FILES["image"]["tmp_name"];
            $folder = "profile/" . $filename;
            if (move_uploaded_file($tempname, $folder)) {
                $data['image'] = $folder;
            }
        }
        if (isset($_POST['address']))
        {
            $data['address'] =  $_POST['address'];
        }
        
        if (isset($_POST['gender']))
        {
            $data['gender'] =  $_POST['gender'];
        }
        if(isset($_SESSION['user']))
        {
            array_push($_SESSION['user'],$data);
            
        }
        else
        {
            $_SESSION['user'] = array();
            array_push($_SESSION['user'],$data);
        }

    }


    

}







?>