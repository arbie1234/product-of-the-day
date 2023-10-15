# Product of the Day Wordpress Plugin


## Description 
This plugin allows for the display and creation of "Products of the day" on wordpress.

## Installation
Copy the plugin folder into `wp-content/plugins` folder and activate the plugin on the wordpress dashboard.

## Usage
After installation the dashboard will have two links 

### Product of the day Settings
This handles the basic configuration of the plugin. Block title etc.

### Product of the day
This will contain the added products via the plugin

### Setting a product of the day
On the product add or edit page, there will be a checkmark that specifies if the product is a "Product of the day". if it is selected it will be included on the random product display of the block (Note: Only 5 products are allowed to be selected as product of the day if it exceeds to more than 5, the oldest product of the day will be untoggled / turned off as a product of the day.

### Setting up in the template
The custom block can be displayed using any theme editors via this shortcode `[product-of-the-day]`

### Click tracking
Once a product is clicked, the plugin will record a log under the `{table_prefix}_call_to_action_clicks` table (this table is created automatically after installation), the log includes the time and the IP address.

# Requirements
1. PHP 8.1 or Greater

2. MariaDB 10.4.28 / MySql

3. <a href="https://make.wordpress.org/core/6-4/">WordPress 6.4</a> 

# Demo
<a href="https://app.screencast.com/rxzU3zyZNlntJ">https://app.screencast.com/rxzU3zyZNlntJ</a>
