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
    return Tpl::loadTemplate('blog_layout', array(
      'cabecera'   => $this->getBlogHeader(),
      'navigation' => $this->getBlogNavigation(),
      'contenido'  => $content,
      'footer'     => $this->getBlogFooter()
      ));
  }

  public function entriesLayout($content = ''){
    return Tpl::loadTemplate('blog_layout', array(
      'cabecera'  => '',
      'navigation' => $this->getBlogNavigation(),
      'contenido' => $content,
      'footer'    => $this->getBlogFooter()
      ));
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

  private function getBlogNavigation(){
    return Tpl::loadTemplate('blog_navigation', array());
  }

  private function getBlogFooter(){
    return Tpl::loadTemplate('blog_footer', array());
  }

}
