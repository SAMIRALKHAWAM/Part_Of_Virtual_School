<?php

if (!function_exists('Success')) {
    function Success($message)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'code' => 200,
            'data' => null
        ], 200);
    }
}

if (!function_exists('SuccessData')) {
    function SuccessData($message, $data)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'code' => 200,
            'data' => $data,
        ], 200);
    }
}


if (!function_exists('Pagination')) {
    function Pagination($data)
    {
        $data = $data->toArray();
        return response()->json([
            'success' => true,
            'message' => 'Found Successfully',
            'per_page' => $data['per_page'],
            'total' => $data['total'],
            'current_page' => $data['current_page'],
            'last_page' => $data['last_page'],
            'data' => $data['data'],
        ], 200);
    }
}

if (!function_exists('UploadFile')) {
    function UploadFile($file, $path)
    {
        $name = $file->getClientOriginalName();
        $newName = rand(9999999999, 99999999999) . $name;
        $file->storeAs('/public/' . $path, $newName);
        return $path . $newName;
    }
}

if (!function_exists('returnPerPage')) {
    function returnPerPage()
    {
        if (request()->hasHeader('perPage') && is_numeric(request()->header('perPage')) && request()->header('perPage') > 0) {
            $perPage = request()->header('perPage');
        } else {
            $perPage = 10;
        }
        return $perPage;
    }
}

if (!function_exists('returnActorType')) {
    function returnActorType()
    {
        if (request()->route()->getPrefix() == 'dashboard_api') {
            return 'Admin';
        } else if (request()->route()->getPrefix() == 'teacher_api') {
            return 'Teacher';
        } else {
            return 'Student';
        }
    }
}
