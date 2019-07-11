<?php
/**
 * Performs all sanitization functions required to save the option values to
 * the database.
 *
 * @package Trinity_Modal
 */
 
/**
 * Performs all sanitization functions required to save the option values to
 * the database.
 *
 * This will also check the specified nonce and verify that the current user has
 * permission to save the data.
 *
 * @package Trinity_Modal
 */
class Serializer {
 
    public function init() {
        add_action( 'admin_post', array( $this, 'save' ) );
    }
 
    public function save() {
        // First, validate the nonce.
        if ( ! ( $this->has_valid_nonce() && current_user_can( 'manage_options' ) ) ) {
            // TODO: Display an error message.
        }
        // If the above are valid, sanitize and save the option.
        if ( null !== wp_unslash( $_POST['post_ids'] ) ) {
            $value =  $_POST['post_ids'] ;
            $valueTitle =  $_POST['title'] ;
            $valueText =  $_POST['text'] ;
            update_option( 'trinity-modal-data', array('ids'=>$value,'title'=>$valueTitle,'text'=>$valueText ) );
        }
        $this->redirect();
 
    }
    private function has_valid_nonce() {
        // If the field isn't even in the $_POST, then it's invalid.
        if ( ! isset( $_POST['post_ids'] ) ) { // Input var okay.
            return false;
        }
        $field  = wp_unslash( $_POST['post_ids'] );
        $action = 'acme-settings-save';
        return wp_verify_nonce( $field, $action );
    }
    private function redirect() {
 
        // To make the Coding Standards happy, we have to initialize this.
        if ( ! isset( $_POST['_wp_http_referer'] ) ) { // Input var okay.
            $_POST['_wp_http_referer'] = wp_login_url();
        }
     
        // Sanitize the value of the $_POST collection for the Coding Standards.
        $url = sanitize_text_field(
            wp_unslash( $_POST['_wp_http_referer'] ) // Input var okay.
        );
     
        // Finally, redirect back to the admin page.
        wp_safe_redirect( urldecode( $url ) );
        exit;
     
    }
}