<?php

class LibZipper extends ZipArchive
{

    public function create_func($input_folder=false, $output_zip_file=false)
    {
        if($input_folder !== false && $output_zip_file !== false)
        {
            ob_clean();
            $res = $this->open($output_zip_file, ZipArchive::CREATE);
            if($res === TRUE) 	{
                $this->addDir($input_folder, basename($input_folder));
                $this->close();
                $chunksize = 5 * (1024 * 1024);
                $size = intval(sprintf("%u", filesize($output_zip_file)));

                header('Content-Type: application/octet-stream');
                header('Content-Transfer-Encoding: binary');
//                header('Content-Length: '.$size);
                header('Content-Disposition: attachment;filename="'.basename($output_zip_file).'"');
                if($size > $chunksize)
                {
                    $handle = fopen($output_zip_file, 'rb');

                    while (!feof($handle))
                    {
                        print(@fread($handle, $chunksize));

                        ob_flush();
                        flush();
                    }

                    fclose($handle);
                }
                else readfile($output_zip_file);
                unlink($output_zip_file);
                $this->my_folder_delete('ImFineThanks');
            } else
                { echo 'Could not create a zip archive. Contact Admin.'; }
        }
    }

    function my_folder_delete($path) {
        if(!empty($path) && is_dir($path) ){
            $dir  = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS); //upper dirs are not included,otherwise DISASTER HAPPENS :)
            $files = new RecursiveIteratorIterator($dir, RecursiveIteratorIterator::CHILD_FIRST);
            foreach ($files as $f) {if (is_file($f)) {unlink($f);} else {$empty_dirs[] = $f;} }
            if (!empty($empty_dirs)) {
                foreach ($empty_dirs as $eachDir) {
                    $tt = rmdir($eachDir);
                }
            }
            rmdir($path);
        }
    }

    // Add a Dir with Files and Subdirs to the archive
    public function addDir($location, $name) {
        $this->addEmptyDir($name);
        $this->addDirDo($location, $name);
    }

    // Add Files & Dirs to archive
    private function addDirDo($location, $name) {
        $name .= '/';         $location .= '/';
        // Read all Files in Dir
        $dir = opendir ($location);
        while ($file = readdir($dir))    {
            if ($file == '.' || $file == '..') continue;
            // Rekursiv, If dir: GoodZipArchive::addDir(), else ::File();
            $do = (filetype( $location . $file) == 'dir') ? 'addDir' : 'addFile';
            $this->$do($location . $file, $name . $file);
        }
    }
}


?>