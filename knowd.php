<?php
/*
Plugin name: Knowd Traffic Widget
Plugin uri: http://exchange.knowd.com/
Author: Knowd, Inc.
Description: Knowd (pronounced "node") is the <strong>easiest way to drive engaged readers to your website or blog</strong>. To get started: 1) Click the "Activate" link to the left of this description, 2) Sign up for a <a href="http://exchange.knowd.com/signup/wordpressplugin">Knowd ID</a>, and 3) Go to your <a href="options-general.php?page=knowd-traffic-widget">WordPress Settings for Knowd Traffic Widget</a>, and enter you Knowd ID.
Version: 1.0.1
*/

function knowd_traffic_widget_post($content)
{
    $domain = "knowd.com";
    $widget_id = get_option("knowd_traffic_widget_widget_id");
    $website_id = get_option("knowd_traffic_widget_website_id");
    if (is_single())
    {
        if ($widget_id != 0)
        {
            $content .= "<script src='http://" . $domain . "/w/" . $widget_id . "/" . $website_id . "/js'></script>";
        }
    }
    return $content;
}

function knowd_traffic_widget_options_page()
{
?>
<div class="wrap">
<h2><img src="<?php echo plugins_url(); ?>/knowd-traffic-widget/logo.png" alt="logo" /></h2>
<?php
    if ($_POST["submit"])
    {
        $id = explode("&", $_POST["id"]);
        $widget = $id[0];
        $website = $id[1];
        if ($widget != 0 && $website != 0)
        {
            update_option("knowd_traffic_widget_widget_id", $widget);
            update_option("knowd_traffic_widget_website_id", $website);
            update_option("knowd_traffic_widget_both_id", $_POST["id"]);
        }
        else
        {
            echo "<div id='message' class='error'><p>We're sorry, that ID was invalid, please try again. If you continue to have problems please contact us at <a href='mailto:support@knowd.com'>support@knowd.com</a>	.</p></div>";
            $err = 1;
        }
    }
    else if ($_POST["deactivate"])
    {
        update_option("knowd_traffic_widget_widget_id", 0);
        update_option("knowd_traffic_widget_website_id", 0);
        update_option("knowd_traffic_widget_both_id", $_POST["id"]);
    }
    $widget_id = get_option("knowd_traffic_widget_widget_id");
    $website_id = get_option("knowd_traffic_widget_website_id");
    $both_id = get_option("knowd_traffic_widget_both_id");
    if ($err == 0 && $widget_id != 0)
    {
?>
<p>Well, isn't this exciting! Your site is now part of the best traffic exchange network in the world...congrats!</p>
<p>What's next, you ask?</p>	
<a href="http://admin.knowd.com/">Upload Your Content**</a>
<ul class="ul-disc">
    <li>Be sure to update your content frequently, as this will help you get the most traffic possible to your site. If you haven't done so yet, be sure to add at least 5 articles to our system. **In order to receive traffic from our network, you MUST have a minimum of 5 articles live at all times**</li>
</ul>
<a href="http://admin.knowd.com/">Customize Your Widget's Content</a>
<ul class="ul-disc">
    <li>Want to tailor the type of content being shown on the widget on your site? You can do that. Here at <a href="http://knowd.com/">knowd.com</a>, it's all about you! Again, completely optional.</li>
</ul>
<a href="http://admin.knowd.com/">Customize Your Widget's Appearance</a>
<ul class="ul-disc">
    <li>This is optional, but if you are so artistically-inclined, you can make your widget looks even prettier (although you have to admit, our stock widget is awfully sexy).</li>
</ul>
<p>Got questions? Visit our handy-dandy FAQ to find answers to the most common questions (top-right corner of the publisher admin) . The FAQ not doing it for you? Feel free to hit us up at <a href="mailto:support@knowd.com">support@knowd.com</a> and we will try our best to help you out.</p>

<p><b>The Knowd Team</b></p>
<form method="post" action="options-general.php?page=knowd-traffic-widget">
<table class="form-table">
<tr>
    <th scope="row">Id</th>
    <td><?php echo $both_id; ?></td>
</tr>
</table>
<br />
<input name="deactivate" type="submit" class="button-primary" value="<?php _e("Deactivate"); ?>" />
</form>
<?php
    }
    else
    {
?>
Thanks for downloading and installing our traffic widget!  If you haven't already done so, you will need to register your widget <b><a href="http://exchange.knowd.com/signup/wordpressplugin" target="_blank">here</a></b> before you can get started.  Upon completion, you will get a unique ID, which you will need to enter below.  Please email us at <a href="mailto:support@knowd.com">support@knowd.com</a> if you have any questions.  Thanks!
<form method="post" action="options-general.php?page=knowd-traffic-widget">
<table class="form-table">
<tr>
    <th scope="row">Id</th>
    <td><input name="id" type="text" value="<?php echo $both_id; ?>" /></td>
</tr>
</table>
<p class="submit">
<input name="submit" type="submit" class="button-primary" value="<?php _e("Activate"); ?>" />
</form>

<?php
    }
?>
</div>

<?php
}

function knowd_traffic_widget_menu()
{
    add_options_page("Knowd Traffic Widget", "Knowd Traffic Widget", "manage_options", "knowd-traffic-widget", "knowd_traffic_widget_options_page");
}

add_filter("the_content", "knowd_traffic_widget_post");
add_action("admin_menu", "knowd_traffic_widget_menu");
?>
