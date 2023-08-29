<?php
class Custom_News_Plugin
{
    private $table_name;

    public function __construct()
    {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'ang_custom_data';


        add_action('init', array($this, 'register_post_type'));
        add_action('add_meta_boxes', array($this, 'add_custom_fields_meta_box'));
        add_action('save_post', array($this, 'save_custom_fields_data'));
        add_shortcode('custom_news', array($this, 'custom_news_shortcode'));

        // Add action to delete custom data when a post is deleted
        add_action('before_delete_post', array($this, 'delete_custom_data_on_post_delete'));

        // Add custom column to the admin listing
        add_filter('manage_news_posts_columns', array($this, 'add_custom_columns'));

        // Populate custom column with data
        add_action('manage_news_posts_custom_column', array($this, 'populate_custom_columns'), 10, 2);

        // Enqueue the frontend CSS file
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_css'));
    }




    public function enqueue_frontend_css()
    {
        wp_enqueue_style('custom-news-frontend-css', plugin_dir_url(__FILE__) . 'custom-news-frontend.css');
    }


    public function delete_custom_data_on_post_delete($post_id)
    {
        global $wpdb;
        $wpdb->delete($this->table_name, array('post_id' => $post_id), array('%d'));
    }



    public function activate()
    {
        error_log('Custom News Plugin activation initiated.');
        $this->create_custom_table();
        flush_rewrite_rules();

        error_log('Custom News Plugin activation completed.');
    }




    private function create_custom_table()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table_name} (
            id INT NOT NULL AUTO_INCREMENT,
            post_id INT NOT NULL,
            title VARCHAR(255),
            image_url VARCHAR(255),
            post_status VARCHAR(20),
            PRIMARY KEY (id),
            UNIQUE KEY post_id (post_id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        $result = dbDelta($sql);
        if (is_wp_error($result)) {
            error_log(print_r($result));
        }
    }

    public function register_post_type()
    {
        $args = array(
            'public' => true,
            'label' => 'News',
            'supports' => array(''),
        );
        register_post_type('news', $args);
    }

    public function add_custom_fields_meta_box()
    {
        add_meta_box(
            'news_custom_fields',
            'News Custom Fields',
            array($this, 'custom_fields_callback'),
            'news',
            'normal'
        );
    }

    public function custom_fields_callback($post)
    {
        $entry = $this->get_custom_data($post->ID);
        $image_url = isset($entry['image_url']) ? $entry['image_url'] : '';
        $title = isset($entry['title']) ? $entry['title'] : '';
        $post_status = isset($entry['post_status']) ? $entry['post_status'] : 'enabled';

        wp_nonce_field('custom_news_nonce', 'custom_news_nonce');

        // Check if there are any validation errors
        $validation_errors = get_transient('custom_news_validation_errors');
        delete_transient('custom_news_validation_errors');

        // Display HTML inputs for custom fields
?>
        <div class="title_field" style="margin-bottom: 10px;">
            <label for="news_title">Title:</label>
            <input type="text" name="news_title" value="<?php echo esc_attr($title); ?>" required style="width: 100%;"><br>
            <?php if ($validation_errors && isset($validation_errors['news_title'])) : ?>
                <p class="error-message"><?php echo esc_html($validation_errors['news_title']); ?></p>
            <?php endif; ?>
        </div>
        <div class="title_field" style="margin-bottom: 10px;">
            <label for="news_image_url">Featured Image URL:</label>
            <input style="width: 100%;" type="text" name="news_image_url" value="<?php echo esc_attr($image_url); ?>" required><br>
            <?php if ($validation_errors && isset($validation_errors['news_image_url'])) : ?>
                <p class="error-message"><?php echo esc_html($validation_errors['news_image_url']); ?></p>
            <?php endif; ?>
        </div>
        <div class="title_field" style="margin-bottom: 10px;">
            <label for="news_status">Post Status:</label>
            <select name="news_status">
                <option value="enabled" <?php selected($post_status, 'enabled'); ?>>Enabled</option>
                <option value="disabled" <?php selected($post_status, 'disabled'); ?>>Disabled</option>
            </select><br>
        </div>
<?php
    }


    public function save_custom_fields_data($post_id)
    {
        if (!isset($_POST['custom_news_nonce'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['custom_news_nonce'], 'custom_news_nonce')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if ('news' !== $_POST['post_type']) {
            return;
        }

        $title = isset($_POST['news_title']) ? sanitize_text_field($_POST['news_title']) : '';
        $image_url = isset($_POST['news_image_url']) ? sanitize_text_field($_POST['news_image_url']) : '';
        $post_status = isset($_POST['news_status']) ? sanitize_text_field($_POST['news_status']) : 'enabled';

        if (empty($title) || trim($title) == '') {
            // Title is empty, display error message and return
            $validation_errors['news_title'] = 'Title cannot be empty.';
        }

        if (!filter_var($image_url, FILTER_VALIDATE_URL)) {
            // Invalid image URL, display error message and return
            $validation_errors['news_image_url'] = 'Image URL must be a valid URL.';
        }

        if (!empty($validation_errors)) {
            set_transient('custom_news_validation_errors', $validation_errors, 30);
            return; // Don't save if there are validation errors
        }

        $this->save_custom_data($post_id, $title, $image_url, $post_status);
    }


    public function add_custom_columns($columns)
    {
        $new_columns = array(
            'cb' => '<input type="checkbox">',
            'custom_title' => 'Custom Title',  // Change 'title' to the desired column name
            'author' => 'Author',
            'date' => 'Date',
        );

        return array_merge($columns, $new_columns);
    }


    public function populate_custom_columns($column, $post_id)
    {
        if ($column === 'custom_title') { // Match the column name you defined
            $entry = $this->get_custom_data($post_id);
            if (!empty($entry['title'])) {
                echo esc_html($entry['title']);
            } else {
                echo 'N/A';
            }
        }
    }



    private function save_custom_data($post_id, $title, $image_url, $post_status)
    {
        global $wpdb;

        $existing_data = $this->get_custom_data($post_id);

        if ($existing_data) {
            $wpdb->update(
                $this->table_name,
                array(
                    'title' => $title,
                    'image_url' => $image_url,
                    'post_status' => $post_status,
                ),
                array('post_id' => $post_id),
                array('%s', '%s'),
                array('%d')
            );
        } else {
            $wpdb->insert(
                $this->table_name,
                array(
                    'post_id' => $post_id,
                    'image_url' => $image_url,
                    'title' => $title,
                    'post_status' => $post_status,
                ),
                array('%d', '%s', '%s')
            );
        }

        // Set the post status to 'publish'
        if ($post_status === 'publish') {
            wp_update_post(array('ID' => $post_id, 'post_status' => 'publish'));
        }
    }

    public function custom_news_shortcode($atts)
    {
        // Shortcode attributes
        $atts = shortcode_atts(array(
            'posts_per_page' => -1, // Default: Show all posts
        ), $atts);

        global $wpdb;
        $output = '';

        // Fetch data from the custom table using WP_Query
        $query = new WP_Query(array(
            'post_type' => 'news',
            'posts_per_page' => intval($atts['posts_per_page']),
        ));

        if ($query->have_posts()) {
            $output .= '<div class="old_mwrapper">';
            while ($query->have_posts()) {
                $query->the_post();
                $entry = $this->get_custom_data(get_the_ID());

                if ($entry && !empty($entry) && $entry['post_status'] == 'enabled') {
                    $output .= '<div class="old_mbox">';
                    $output .= '<div class="o_img"><a href="' . esc_html(get_the_permalink()) . '"><img src="' . esc_html($entry['image_url']) . '" alt=""></a></div>';
                    $output .= '<div class="old_cont"><h4>' . esc_html($entry['title']) . '</h4> <a href="' . esc_html(get_the_permalink()) . '" class="readm">Read more</a></div>';
                    $output .= '</div>';
                }
            }
            $output .= '</div>';
            wp_reset_postdata();
        } else {
            $output .= '<p>No news entries found.</p>';
        }

        return $output;
    }

    private function get_custom_data($post_id)
    {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM {$this->table_name} WHERE post_id = %d", $post_id), ARRAY_A);
    }
}
