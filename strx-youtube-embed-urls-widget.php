<?php 
class StrxYoutubeEmbedUrls_Widget extends Strx_Widget {
    /********************************************* 
        Wordpress Core functions
    **********************************************/

    /** Return the pugin id, ie: my-plugin (abstract) */
    function w_id(){ return 'strx-youtube-embed-urls'; }
    /** Return the pugin name, ie: My Plugin (abstract) */
    function w_name(){ return 'Strx Youtube Embed Urls'; }
    

    /********************************************* 
        Content functions 
    **********************************************/

    /** Return the dashboard admin form */
    function w_form($instance){
        $rv='';
        $rv.=   '<p>'.$this->w_form_input($instance, 'title').'</p>';
        $rv.=   '<p>'.$this->w_form_textarea($instance, 'urls').'</p>';
        $rv.=   '<p>'.$this->w_form_input($instance, 'width').'</p>';
        $rv.=   '<p>'.$this->w_form_input($instance, 'height').'</p>';
        $rv.=   '<p>'.$this->w_form_input($instance, 'vmargin', 'Vertical Margin between videos in pixels').'</p>';
        return $rv;
    }

    /** Return the real widget content */
    function w_content($instance){
        extract($instance);
        $rv='';
        foreach(explode("\n", $urls) as $url){
            if (preg_match('/v=(\w+)/', $url, $v)){
                $v=$v[1];
                $rv.=   '<div class="'.$this->id_base.'-video" style="margin-bottom: '.$vmargin.'px;">'.
                            '<iframe title="Strx.it YouTube video player" class="'.$this->id_base.' youtube-player" type="text/html" '.
                                'width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$v.'?wmode=transparent" frameborder="0">'.
                            '</iframe>'.
                        '</div>';
            }
        }
        return $rv;
    }    

    /** Widget Default Options, abstract */
    function w_defaults(){
        return array(
            'title' => __($this->w_name()),
            'urls' => "http://www.youtube.com/watch?v=7XEujPG7Zjw",  //redhat linux commercial
            'width' => '100%',
            'height' => '',
            'vmargin' => '8'
        );
    }
}

StrxYoutubeEmbedUrls_Widget::w_init('StrxYoutubeEmbedUrls_Widget');
