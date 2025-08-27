<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Unzip the source_file in the destination dir
 *
 * @param   string      The path to the ZIP-file.
 * @param   string      The path where the zipfile should be unpacked, if false the directory of the zip-file is used
 * @param   boolean     Indicates if the files will be unpacked in a directory with the name of the zip-file (true) or not (false) (only if the destination directory is set to false!)
 * @param   boolean     Overwrite existing files (true) or not (false)
 *  
 * @return  boolean     Succesful or not
 */
function unzip($src_file, $dest_dir=false, $create_zip_name_dir=true, $overwrite=true) 
{
  $archive = new ZipArchive();
  $opened = $archive->open($src_file);
  if ($opened === true) 
  {
    $splitter = ($create_zip_name_dir === true) ? "." : "/";
    if ($dest_dir === false) $dest_dir = substr($src_file, 0, strrpos($src_file, $splitter))."/";
    
    // Create the directories to the destination dir if they don't already exist
    create_dirs($dest_dir);

    $archive->extractTo($dest_dir);

    // Close the zip-file
    $archive->close();
  } 
  else
  {
    return false;
  }
  
  return true;
}

/**
 * This function creates recursive directories if it doesn't already exist
 *
 * @param String  The path that should be created
 *  
 * @return  void
 */
function create_dirs($path)
{
  if (!is_dir($path))
  {
    $directory_path = "";
    $directories = explode("/",$path);
    array_pop($directories);
    
    foreach($directories as $directory)
    {
      $directory_path .= $directory."/";
      if (!is_dir($directory_path))
      {
        mkdir($directory_path);
        //chmod($directory_path, 0755);
      }
    }
  }
}

