
<?php 
/**
 * Method to redirect to the previous page
 *
 * Add to one of your helpers
 *
 * USEAGE: redirectPreviousPage();
 */
if ( ! function_exists('redirectPreviousPage'))
{
    function redirectPreviousPage()
    {
        if (isset($_SERVER['HTTP_REFERER']))
        {
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
        else
        {
            header('Location: http://'.$_SERVER['SERVER_NAME']);
        }
        
        exit;
    }
}

 