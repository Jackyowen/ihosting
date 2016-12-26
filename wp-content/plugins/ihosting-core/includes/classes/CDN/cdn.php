<?php

/**
 * Created by PhpStorm.
 * User: Kutethemes
 * Author: Kutethemes
 * Date: 25/04/2016
 * Time: 8:46 SA
 */
class KT_CDN
{
    public $root_url =  "";
    public $css_url  = "";
    public $js_url   = "";
    public $file_extensions = "bmp|bz2|gif|ico|gz|jpg|jpeg|mp3|pdf|png|rar|rtf|swf|tar|tgz|txt|wav|zip";
    public $css_extensions  = "css";
    public $js_extensions   = "js";

    public function __construct()
    {
        $this->root_url = $this->css_url = $this->js_url = untrailingslashit(kutetheme_ovic_option('kt_cdn_root_url'));

        if ($css_url = trim(kutetheme_ovic_option('kt_cdn_css_url'))) {
            $this->css_url = untrailingslashit($css_url);
        }

        if ($js_url = trim(kutetheme_ovic_option('kt_cdn_js_url'))) {
            $this->js_url = untrailingslashit($js_url);
        }

        if( $file_extensions = kutetheme_ovic_option('kt_cdn_file_extensions') ){
            $this->file_extensions = $file_extensions;
        }

        if( $css_extensions = kutetheme_ovic_option('kt_cdn_css_extensions') ){
            $this->css_extensions  = $css_extensions;
        }

        if( $js_extensions = kutetheme_ovic_option('kt_cdn_js_extensions') ){
            $this->js_extensions = $js_extensions;
        }
    }
    public function ini(){
        if ('' == $this->file_extensions || '' == $this->root_url) {
            add_action('admin_notices', array($this, 'settings_warning'));
            return;
        }

        if('/' != $this->root_url) {
            $action = (defined('XMLRPC_REQUEST') && XMLRPC_REQUEST) ? 'xmlrpc_call' : 'template_redirect';
            add_action($action, array($this, 'start_filter'), 1);
        }
    }

    public function settings_warning(){
        echo "<div class='update-nag'>The CDN Rewrite plugin is missing some required settings.</div>";
    }
    
    public function start_filter() {
        ob_start(array($this, 'filter_urls'));
    }
    /**
     * Callback for output filter.  Search content for urls to replace
     *
     * @param string $content
     * @return string
     */
    public function filter_urls($content) {

        $root_url = $this->get_site_root_url();
        $xml_begin = $xml_end = '';
        if (defined('XMLRPC_REQUEST') && XMLRPC_REQUEST) {
            $xml_begin = '>';
            $xml_end = '<';
        }
        $extensions = join('|', array_filter(array($this->file_extensions, $this->css_extensions, $this->js_extensions)));

        // replace srcset values
        $srcset_regex = '#<img[^\>]*[^\>\S]+srcset=[\'"]('.quotemeta($root_url).'(?:([^"\'\s,]+)('.$this->file_extensions.')\s*(?:\s+\d+[wx])(?:,\s*)?)+)["\'][^>]*?>#';
        $content = preg_replace_callback( $srcset_regex, array($this, 'srcset_rewrite'), $content);

        // replace the remaining urls
        $regex = '#(?<=[(\"\''.$xml_begin.'])'.quotemeta($root_url).'(?:(/[^\"\''.$xml_end.')]+\.('.$extensions.')))#';
        $content = preg_replace_callback($regex, array($this, 'url_rewrite'), $content);

        return $content;
    }
    /**
     * Callback for url preg_replace_callback.  Returns corrected URL
     *
     * @param array $match
     * @return string
     */
    public function url_rewrite($match) {
        $path = $this->get_rewrite_path( $match[1] );
        if('/' !== $this->css_url && preg_match("/^.*\.(".$this->css_extensions.")$/i", $path) ) {
            return $this->css_url . $path;
        }
        if('/' !== $this->js_url && preg_match("/^.*\.(".$this->js_extensions.")$/i", $path) ) {
            return $this->js_url . $path;
        }
        return $this->root_url . $path;
    }

    /**
     * Returns the root url of the current site
     *
     * @return string
     */
    public function get_site_root_url() {
        if(is_multisite() && !is_subdomain_install()) {
            $root_blog = get_blog_details(1);
            $root_url = $root_blog->siteurl;
        } else {
            $root_url = site_url();
        }
        return $root_url;
    }

    /**
     * Callback for srcset preg_replace_callback, Returns image tag with updated srcset value
     * @param type $match
     * @return type
     */
    public function srcset_rewrite( $match ) {
        $root_url = $this->get_site_root_url();

        $image_tag           = empty( $match[0] ) ? false : $match[0];
        $srcset_field        = empty( $match[1] ) ? false : $match[1];
        if ( empty( $srcset_field ) ) {
            return $image_tag;
        }

        $srcset_images       = array();
        $srcset_images_paths = empty( $srcset_images[1] ) ? false : $srcset_images[1];

        if ( empty( $srcset_images_paths ) ) {
            return $image_tag;
        }

        foreach( $srcset_images_paths as $key => $original_path ) {
            $path     = $this->get_rewrite_path( $original_path );
            $cdn_path = $this->root_url . $path;
            $srcset_images[0][ $key ] = str_replace( $root_url . $original_path, $cdn_path, $srcset_images[0][ $key ] );
        }

        $image_tag = str_replace( $srcset_field, implode( ' ', $srcset_images[0] ), $image_tag );

        return $image_tag;
    }
    /**
     * Helper function to get the path depending on the site structure
     * @global type $blog_id
     * @param string $path
     * @return string
     */
    private function get_rewrite_path( $path ) {
        global $blog_id;
        //if is subfolder install and isn't root blog and path starts with site_url and isnt uploads dir
        if(is_multisite() && !is_subdomain_install() && $blog_id !== 1) {
            $bloginfo = $this->get_this_blog_details();
            if((0 === strpos($path, $bloginfo->path)) && (0 !== strpos($path, $bloginfo->path.'files/'))) {
                $path = '/'.substr($path, strlen($bloginfo->path));
            }
        }
        return $path;
    }
    /**
     * Returns the details for the current blog
     *
     * @return object
     */
    public function get_this_blog_details() {
        if(!isset($this->blog_details)) {
            global $blog_id;
            $this->blog_details = get_blog_details($blog_id);
        }
        return $this->blog_details;
    }

}