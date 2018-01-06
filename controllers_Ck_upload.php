<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ck_upload extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    ##############################################################################################################
    ## Upload form CKeditor
    ##############################################################################################################
    public function upload_ck()
    {
        ob_get_level();

        //Image Save Option
		//저장 옵션
        $getpath = $this->input->get('path');
        $path = 'assets/upload/'.$getpath.'/';

        $config['upload_path'] = './'.$path; //YOUR PATH
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '0';
        $config['file_name'] = 'file_name';
        $config['remove_spaces'] = TRUE;

        //Form Upload, Drag & Drop
        $CKEditorFuncNum = $this->input->get('CKEditorFuncNum');
        if(empty($CKEditorFuncNum))
        {
            ////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Drag & Drop
            ////////////////////////////////////////////////////////////////////////////////////////////////////////
            header('Content-Type: application/json');

            $this->load->library('upload', $config);
            if ( !$this->upload->do_upload("upload"))
            {
                $jsondata = array('uploaded'=> 0, 'fileName'=> 'null', 'url'=> 'null');
                echo json_encode($jsondata);
            }
            else
            {
                $data = $this->upload->data();

                // JPG compression
                if($this->upload->data('file_ext') === '.jpg') {
                    $filename = $this->upload->data('full_path');
                    $img = imagecreatefromjpeg($filename);
                    imagejpeg($img, $filename, 80);
                }

                $filename = $data['file_name'];
                $url = base_url().$path.$filename;

                $jsondata = array('uploaded'=> 1, 'fileName'=> $filename, 'url'=> $url);
                echo json_encode($jsondata);
            }
        }
        else
        {
            ////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Form Upload
            ////////////////////////////////////////////////////////////////////////////////////////////////////////
            $this->load->library('upload', $config);
            if ( !$this->upload->do_upload("upload"))
            {
                echo "<script>alert('Send Fail".$this->upload->display_errors('','')."')</script>";
            }
            else
            {
                $CKEditorFuncNum = $this->input->get('CKEditorFuncNum');
                $data = $this->upload->data();

                // JPG compression
                if($this->upload->data('file_ext') === '.jpg') {
                    $filename = $this->upload->data('full_path');
                    $img = imagecreatefromjpeg($filename);
                    imagejpeg($img, $filename, 80);
                }

                $filename = $data['file_name'];

                $url = base_url().$path.$filename;
                echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction('".$CKEditorFuncNum."', '".$url."', 'Send OK')</script>";
            }
        }

        ob_end_flush();
    }
}
