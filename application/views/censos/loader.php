<?php
$this->load->view('layout/header');
$this->load->view('layout/menubar', $sub_menu_censos);

$this->load->view( $module . '/' . $view);
/*if (isset($content))
    $this->load->view( $module . '/' . $content);
if (isset($result))
    $this->load->view( $module . '/' . $result);
echo "</div>";
*/
$this->load->view('layout/footer');
?>