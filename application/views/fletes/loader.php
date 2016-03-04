<?php
$this->load->view($view_dir.'/'.'layout/header');
if (isset($sub_menu))
 	$this->load->view($view_dir.'/'.'layout/menubar', $sub_menu);
else
	$this->load->view($view_dir.'/'.'layout/menubar');

$this->load->view($view_dir .'/'. $module . '/' . $view);
/*if (isset($content))
    $this->load->view( $module . '/' . $content);
if (isset($result))
    $this->load->view( $module . '/' . $result);
echo "</div>";
*/
$this->load->view($view_dir.'/'.'layout/footer');
?>