<?php
/**
 * Plugin Videogg: Show Theora video from url.
 *
 * @license    GPL v3 (http://www.gnu.org/licenses/gpl.html)
 * @author     Ludovic Kiefer
 *
 * Based on the Dailymotion plugin written by Christophe Benz,
 * which is based on the Youtube plugin written by Ikuo Obataya.
 */
 
if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
 
class syntax_plugin_videogg extends DokuWiki_Syntax_Plugin {
  function getInfo(){
    return array(
      'author' => 'Ludovic Kiefer',
      'email'  => 'ludovic _AT_ skolelinux _DOT_ com',
      'date'   => '2010-03-04',
      'name'   => 'OGG Video Plugin',
      'desc'   => 'Show Ogg Theora videos, using the html5 video tag.',
      'url'    => 'http://www.dokuwiki.org/plugin:videogg',
    );
  }
 
  function getType() { return 'substition'; }
  function getSort() { return 159; }
 
  function connectTo($mode) { $this->Lexer->addSpecialPattern('\{\{videogg>[^}]*\}\}', $mode, 'plugin_videogg'); }
 
  /**
   * Handle the match
   */
  function handle($match, $state, $pos, &$handler){
    $params = substr($match, strlen('{{videogg>'), - strlen('}}') ); // Strip markup
    return array($state, explode('|', $params));
  }	
 
  /**
   * Create output
   */
  function render($mode, &$renderer, $data) {
    if($mode == 'xhtml'){
      list($state, $params) = $data;
      list($video_url, $video_size) = $params;
 
      if(substr($video_url,-3) != 'ogg' && substr($video_url,-3) != 'ogv') {
        $renderer->doc .= 'Erreur: La vidéo doit avoir l\'extention ogv ou ogg.<br/>'.$video_url;
        return false;
      }
 
      if(is_null($video_size) or ! substr_count  ( $video_size  , 'x')) {
        $width  = 200;
        $height = 166;
      }
      else{
      	$obj_dimensions = explode('x' , $video_size);
      	$width          = $obj_dimensions[0];
     	   $height         = $obj_dimensions[1];
      }
 
 
 
      //$obj  = '<div>';
      $obj .= '<video src="'. $video_url .'" width="'. $width .'" height="'. $height .'" controls></video><br/>'; 
      $obj .= '<a href="'. $video_url .'"><small>Télécharger la vidéo</small></a>';      
      //$obj .= '</div>';
 
      $renderer->doc .= $obj;
 
      return true;
    }
    return false;
  }
}
?>
