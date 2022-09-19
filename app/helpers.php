<?php

if (! function_exists('singleFileUpload')) {

    function singleFileUpload($image, $folder, $name)
    {
        $imageName = $name;
        $image->move(public_path('assets/' . $folder), $imageName);
        return 'assets/' . $folder . '/' . $imageName;
    }

    function uploadFile($image, $folder, $name)
    {
        $imageName = $name;
        if (!file_exists(public_path($folder))) {
            mkdir(public_path($folder), 0777, true);
        }
        $image->move(public_path($folder), $imageName);
        return public_path($folder) . '/' . $imageName;
    }

}
