<?php

class Layout {
  protected $dir;
  protected $file;

  private function setPath($template){
    if(file_exists(getcwd().'/tpls/'.$template.'.php')){
      $dir = getcwd().'/tpls/';
    } elseif(file_exists(SYSROOT.'/tpls/'.$template.'.php')){
      $dir = SYSROOT.'/tpls/';
    }else{
      trigger_error("TPL_NOT_FOUND|NO SE ENCUENTRA EL ARCHIVO ".$template." en ".getcwd().'/tpls/'.$template.'.php ni en '.SYSROOT.'/tpls/'.$template.'.php');
    }
    return $dir;
  }
  public function loadTemplate($template = null, $data = array()){
    $dir = $this->setPath($template);
    return Tpl::loadTemplate($template, $data, $dir); // or trigger_error("TPL_PROBLEM|NO SE QUE ONDA...");
  }

  public function simpleLayout($content = ''){
    $dir = SYSROOT.'tpls/';
    return Tpl::loadTemplate('layout', array(
      'cabecera'  => $this->getHeader(),
      'botonera'  => $this->getButtons(),
      'contenido' => $content,
      'footer'    => $this->getFooter()
      ), $dir);
  }

  public function mobiLayout($content = ''){
    $dir = SYSROOT.'tpls/';
    return Tpl::loadTemplate('mobi', array(
      'cabecera'  => $this->getHeader(),
      'botonera'  => $this->getButtons(),
      'contenido' => $content,
      'footer'    => $this->getFooter()
      ), $dir);
  }

  public function bootLayout($content = ''){
    $dir = SYSROOT.'tpls/';
    return Tpl::loadTemplate('bootstrap', array(
      'contenido' => $content
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

  public function deskLayout($content = ''){
    $dir = SYSROOT.'tpls/';
    return Tpl::loadTemplate('desk', array(
      'botonera'  => $this->getButtons(),
      'contenido' => $content,
      'footer'    => $this->getFooter()
      ), $dir);
  }

  public function printLayout($content = ''){
    $dir = SYSROOT.'tpls/';
    return Tpl::loadTemplate('print', array(
      'contenido' => $content
      ), $dir);
  }

  private function getNavigation(){
    $dir = $this->setPath('navigation');
    return Tpl::loadTemplate('navigation', array(), $dir);
  }

  private function getHeader(){
    $dir = $this->setPath('cabecera');
    return Tpl::loadTemplate('cabecera', array(), $dir);
  }

  private function getButtons(){
    $dir = $this->setPath('botonera');
    return Tpl::loadTemplate('botonera', array(), $dir);
  }

  private function getFooter(){
    $dir = $this->setPath('footer');
    return Tpl::loadTemplate('footer', array(), $dir);
  }

}
