<?php
namespace Aivec\Welcart\Generic;

/**
 * Verifies whether Welcart is activated or not. Optionally displays error message on
 * admin page if not activated.
 */
class WelcartActivationVerification {
   
    /**
     * True if activated, false otherwise
     *
     * @var boolean
     */
    public $activated;

    /**
     * Initializes activated member var
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @return void
     */
    public function __construct() {
        $this->activated = false;
        if (defined('USCES_VERSION')) {
            $this->activated = true;
        }

        load_textdomain('wgeneric', __DIR__ . '/languages/wgeneric-ja.mo');
        load_textdomain('wgeneric', __DIR__ . '/languages/wgeneric-en.mo');
    }
   
    /**
     * Registers admin_notices hook if Welcart is deactivated and displays
     * error message at top of admin page
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @param string $plugin_name
     * @return void
     */
    public function displayAdminErrorMessage($plugin_name) {
        if ($this->activated === false) {
            add_action('admin_notices', function () use ($plugin_name) {
                ?>
                <div class="message error">
                    <p>
                        <?php echo sprintf(
                            // translators: display name for plugin that depends on Welcart
                            __('%s depends on Welcart but it is deactivated. Please activate Welcart.', 'wgeneric'),
                            $plugin_name
                        ) ?>
                    </p>
                </div>
                <?php
            });
        }
    }
}
