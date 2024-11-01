<?php 
class StrxYoutubeEmbedUser_Widget extends Strx_Widget {
    /********************************************* 
        Wordpress Core functions
    **********************************************/

    /** Return the pugin id, ie: my-plugin (abstract) */
    function w_id(){ return 'strx-youtube-embed-user'; }
    /** Return the pugin name, ie: My Plugin (abstract) */
    function w_name(){ return 'Strx Youtube Embed User'; }
    

    /********************************************* 
        Content functions 
    **********************************************/

    /** Return the dashboard admin form */
    function w_form($instance){
        $rv='';
        $rv.=   '<p>'.$this->w_form_input($instance, 'title').'</p>';
        $rv.=   '<p>'.$this->w_form_input($instance, 'user', 'YouTube User/Channel').'</p>';
        $rv.=   '<p>'.$this->w_form_input($instance, 'max', 'Max Videos').'</p>';
        $rv.=   '<p>'.$this->w_form_input($instance, 'width').'</p>';
        $rv.=   '<p>'.$this->w_form_input($instance, 'height').'</p>';
        $rv.=   '<p>'.$this->w_form_input($instance, 'vmargin', 'Vertical Margin between videos in pixels').'</p>';
        return $rv;
    }

    /** Return the real widget content */
    function w_content($instance){
        extract($instance);
        $rv='';
        $f=@fopen("http://gdata.youtube.com/feeds/api/videos?v=2&author=$user&alt=json&orderby=published&max-results=$max",'r');
        if ($f){
            $json = stream_get_contents($f);
            fclose($f);
            $json =json_decode($json);
            $videos=$json->feed->entry;
            $t='$t';
            foreach($videos as $video){
                //preg_match('/\w+$/', $video->id->$t, $id);
				preg_match('/[a-zA-Z0-9-_]+$/', $video->id->$t, $id);
                $id=$id[0];
                $rv.=   '<div class="'.$this->id_base.'-video" style="margin-bottom: '.$vmargin.'px;">'.
                            '<iframe title="Strx.it YouTube video player" class="'.$this->id_base.' youtube-player" type="text/html" '.
                                'width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$id.'?wmode=transparent" frameborder="0">'.
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
            'user' => "UbuntuAds",  //redhat linux commercial
            'max' => '1',
            'width' => '100%',
            'height' => '',
            'vmargin' => '8'
        );
    }
}

StrxYoutubeEmbedUser_Widget::w_init('StrxYoutubeEmbedUser_Widget');
