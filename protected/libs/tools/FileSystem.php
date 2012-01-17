<?php


class FileSystem
{
    public static function getUniqFileName($file, $dir)
    {
        $dir = trim('/', $dir);

        if (mb_strpos($dir, $_SERVER['DOCUMENT_ROOT']) === false)
        {
            $dir = $_SERVER['DOCUMENT_ROOT'] . $dir . '/';
        }

        $ext  = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $name = md5(rand(0, getrandmax()) . uniqid("", true) . uniqid("", true) . $file) . '.' . $ext;

        if (file_exists($dir . $name))
        {
            self::getUniqFileName($name, $dir);
        }

        return $name;
    }


    public static function deleteDirRecursive($dir_name)
    {
        if (!is_dir($dir_name)) return false;

        $dir_handle = opendir($dir_name);
        
        if (!$dir_handle) return false;

        while(($file = readdir($dir_handle)) !== false)
        {
            if ($file == "." or $file == "..") continue;
           
            if (!is_dir($dir_name."/".$file))
            {
                unlink($dir_name."/".$file);
            } 
            else
            {
                self::deleteDirRecursive($dir_name.'/'.$file);
            }
        }

        rmdir($dir_name);
        closedir($dir_handle);
        return true;
    }


    public static function findSimilarFiles($dir, $file)
    {
        $dir_files     = scandir($dir);
        $similar_files = array();

        foreach ($dir_files as $dir_file)
        {
            if ($dir_file == '.' || $dir_file == '..' || $dir_file == $file) continue;
         
            if (strpos($dir_file, $file) !== false) $similar_files[] = $dir_file;
        }

        return $similar_files;
    }


    public static function deleteFileWithSimilarNames($dir, $file)
    {
        $files = array_merge(
            array($file),
            self::findSimilarFiles($dir, $file)
        );

        self::unlinkFiles($dir, $files);
    }


    public static function unlinkFiles($dir, $files)
    {
        foreach ($files as $file)
        {
            $file_path  = $dir . $file;

            if (file_exists($file_path))
            {	
                unlink($file_path);
            }
        }
    }
}
