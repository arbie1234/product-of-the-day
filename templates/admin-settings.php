<?php
/**
 * Admin Settings Template
 */

?>
<h2 class="font-semibold text-gray-700"> Product of the day settings</h2>


<div class="bg-white rounded-lg shadow-md meta-box-sortables ui-sortable">
    <form class="flex-row pt-8 mt-2 ml-5 mr-4 text-left item-center" method="post" action="">

        <?php if(isset($_GET['potd_success'])): ?>
            <div id="message" class="notice notice-success is-dismissible updated" style="margin-left:0px;">
                        <p>Settings updated.
                    <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.
                    </span>
                </button>
            </div>
        <?php endif; ?>

      
        <!-- Admin Email -->
        <div class="flex flex-row border-b border-gray-100">
            <div class="flex w-1/5">
                <div class="pt-6">
                    <label for="registration_notification_email" class="text-sm font-medium text-gray-600 pb-2">Admin Email</label>
                </div>
            </div>
            <div class="flex w-100">
                <div class="w-full h-10 mt-4 mb-4 ml-16 mr-4">
                    <div class="relative h-10">
                        <input type="email" name="product_of_the_day[product_of_the_day_email]" id="product_of_the_day_email" class="font-normal text-gray-600 h-8 shadow-sm" value="<?=$product_of_the_day_email ?>"  style="min-width:500px;">
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <!-- Block Title -->
        <div class="flex flex-row border-b border-gray-100">
            <div class="flex w-1/5">
                <div class="pt-6">
                    <label for="block_title" class="text-sm font-medium text-gray-600 pb-2">Block Title</label>
                </div>
            </div>
            <div class="flex w-100">
                <div class="w-full h-10 mt-4 mb-4 ml-16 mr-4">
                    <div class="relative h-10">
                        <input type="text" name="product_of_the_day[block_title]" id="block_title" class="font-normal text-gray-600 h-8 shadow-sm" value="<?=$block_title ?>" style="min-width:500px;">
                    </div>
                </div>
            </div>
        </div>


        <!-- Submit -->
        <p class="submit">
            <input type="submit" class="wpdp-form-submit-button bg-indigo-600 p-2 rounded text-white cursor-pointer hover:bg-indigo-600" value="<?php esc_html_e( 'Submit', 'product-of-the-day' ); ?>">
        </p>

		<?php wp_nonce_field( 'product_of_the_day_settings', 'potd-settings-nonce', true, true ); ?>

    </form>
</div>
