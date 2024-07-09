<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


class form_addon extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'elementor_contact_form_widget';
    }

    public function get_title()
    {
        return __('Contact form', 'elementor-contact-form-addon');
    }

    public function get_icon()
    {
        return 'eicon-form-horizontal';
    }

    public function get_categories()
    {
        return ['basic'];
    }

    protected function _register_controls()
    {

        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'elementor-contact-form-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'form_title',
            [
                'label' => __('Title', 'elementor-contact-form-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Contact Form', 'elementor-contact-form-addon'),
                'placeholder' => __('Enter your form title', 'elementor-contact-form-addon'),
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
?>

        <div class="elementor-contact-form-widget">
            <h2 class="contact_form_heading"><?php echo esc_html($settings['form_title']); ?></h2>
            <form action="" method="post" enctype="multipart/form-data">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-detail-name" required>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-detail-email" required>
                <input type="textarea" rows="5" cols="10" id="short-message" name="message" class="message" placeholder="Enter Your Message:"><br>
                <input type="submit" class="form-btn" value="Submit">
            </form>
        </div>

    <?php
    }

    protected function _content_template()
    {
    ?>
        <!-- <#
        var settings = settings;
        #> -->
        <div class="elementor-contact-form-widget">
            <h2 class="contact_form_heading">{{{ settings.form_title }}}</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-detail-name" required>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-detail-email" required>
                <input type="textarea" id="short-message" name="message" class="message" placeholder="Enter Your Message:"><br>
                <input type="submit" class="form-btn" value="Submit">
            </form>
        </div>
<?php
    }
}
