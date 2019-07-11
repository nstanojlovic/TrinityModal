<?php
class Content_messenger {

    /**
    * A reference to the class for retrieving our option values.
    *
    * @access private
    * @var Deserializer
    */
    private $deserializer;

    /**
    * Initializes the class by setting a reference to the incoming deserializer.
    *
    * @param Deserializer $deserializer Retrieves a value from the database.
    */
    public function __construct( $deserializer ) {
        $this->deserializer = $deserializer;
    }

    /**
    * Initializes the hook responsible for prepending the content with the
    * option created on the options page.
    */
    public function init() {
        add_filter( 'the_content', array( $this, 'display' ) );
    }

    public function display($content) { 
        $data = $this->deserializer->get_value('trinity-modal-data');
        if ( !is_archive() && !is_front_page() ){
            if ( in_array(get_the_ID(),$data['ids'])) {
                echo '<div class="ovelay">';
                echo '<div class="modal">';
                echo '<div class="modal-header">'. $data['title'].'</div>';
                echo '<div class="modal-body">'. $data['text'].'</div>';
                echo '</div>';
                echo '</div>';
            }
        }
        return $content;
    }

}
?>
