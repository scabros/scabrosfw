<?php

class Layout {
  protected $dir;
  protected $file;

  public function loadTemplate($template = null, $data = array()){
    return Tpl::loadTemplate($template, $data); // or trigger_error("TPL_PROBLEM|NO SE QUE ONDA...");
  }

  public function mobiLayout($content = ''){
    $dir = SYSROOT.'tpls/';
    return Tpl::loadTemplate('layout', array(
      'cabecera'  => $this->getHeader(),
      'botonera'  => $this->getButtons(),
      'contenido' => $content,
      'footer'    => $this->getFooter()
      ), $dir);
  }


  public function blogLayout($content = ''){
    $dir = SYSROOT.'tpls/';
    return Tpl::loadTemplate('blog_layout', array(
      'cabecera'  => $this->getBlogHeader(),
      'contenido' => $content,
      'footer'    => $this->getBlogFooter()
      ), $dir);
  }

  public function entriesLayout($content = ''){
    $dir = SYSROOT.'tpls/';
    return Tpl::loadTemplate('entries', array(
      'ads_header' => '',
      'ads_footer' => '',
      'contenido'  => $content
      ), $dir);
  }

  private function getNavigation(){
    return Tpl::loadTemplate('navigation', array());
  }

  private function getHeader(){
    return Tpl::loadTemplate('cabecera', array());
  }

  private function getButtons(){
    return Tpl::loadTemplate('botonera', array());
  }

  private function getFooter(){
    return Tpl::loadTemplate('footer', array());
  }

  private function getBlogHeader(){
    return Tpl::loadTemplate('blog_header', array());
  }

  private function getBlogFooter(){
    return Tpl::loadTemplate('blog_footer', array());
  }

}
