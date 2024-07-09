<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class drop_down extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'category_posts_widget';
    }

    public function get_title()
    {
        return __('Category Dropdown', 'elementor-category-posts-widget');
    }

    public function get_icon()
    {
        return 'eicon-post-list';
    }

    public function get_categories()  // this method defines the categories in which the widget will be display in the elementor
    {
        return ['basic']; // widget will be display in the basic category to make it easier for the use to find and use them in the editor
    }

    protected function _register_controls()
    {
        $categories = get_categories([   //get_categories retrieves categories save int he database
            'orderby' => 'name',
            // 'order' => 'ASC',
        ]);

        $category_options = ['all' => __('All', 'elementor-category-posts-widget')];
        foreach ($categories as $category) {
            $category_options[$category->term_id] = $category->name;
        }
       
        //starts the new section in the elementor 
        $this->start_controls_section(
            'content_section',  // unique identifier for the section
            [
                'label' => __('Content', 'elementor-category-posts-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'category',
            [
                'label' => __('Category', 'elementor-category-posts-widget'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $category_options,
                'default' => array_key_first($category_options),
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __('Order', 'elementor-category-posts-widget'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'ASC' => __('Ascending', 'elementor-category-posts-widget'),
                    'DESC' => __('Descending', 'elementor-category-posts-widget'),
                ],
                'default' => 'ASC',
            ]
        );

        $this->end_controls_section(); //ends the section
    }

    protected function render() //interface for useer
    {
        $settings = $this->get_settings_for_display();
        $category_id = $settings['category'];
        $order = $settings['order'];

        $query_args = [
            'cat' => $category_id,
            'order' => $order,
            // 'posts_per_page' => -1,
        ];
        $query = new WP_Query($query_args);
        ?>
        <div class="category-posts-widget">
            <div class="post-in-order">
                <?php if ($query->have_posts()) : ?>
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                        <div class="category-post">
                        <p class="post-featured-image"><?php the_post_thumbnail(); ?></p>
                            <h2 class="post-title"><?php the_title(); ?></h2>
                            <p class="post-description"><?php the_excerpt(); ?></p>
                            <a href="<?php the_permalink(); ?>">Read More</a>
                        </div>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php else : ?>
                    <p><?php _e('No posts found', 'elementor-category-posts-widget'); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    protected function get_all_categories() {
        $categories = get_categories();
        $options = array();
        foreach ($categories as $category) {
            $options[$category->term_id] = $category->name;
        }
        return $options;
    }
}
?>
