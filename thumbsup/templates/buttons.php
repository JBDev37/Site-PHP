<?php defined('THUMBSUP_DOCROOT') or exit('No direct script access');
/**
 * ThumbsUp
 *
 * @author     Geert De Deckere <geert@idoe.be>
 * @link       http://geertdedeckere.be/shop/thumbsup/
 * @copyright  Copyright 2009-2016
 */
?>

<form method="post" id="thumbsup_<?php echo $item->id ?>" class="thumbsup <?php echo $template ?> <?php if ($item->closed) echo 'closed' ?> <?php if ($item->user_voted) echo 'user_voted' ?> <?php if ($item->closed OR $item->user_voted) echo 'disabled' ?>" name="<?php echo $template ?>">
	<input type="hidden" name="thumbsup_id" value="<?php echo $item->id ?>">
	<input type="hidden" name="thumbsup_format" value="<?php echo htmlspecialchars($item->format) ?>">
	<button class="signaler" style="color:red; border-width:0px; width: 20px; background-color: #ffffff; " name="thumbsup_vote" value="-1" <?php if ($item->closed OR $item->user_voted) echo 'disabled="disabled"' ?>><?php echo htmlspecialchars($options->signaler) ?></button>
</form>
