var tab_opened = meChatTab_Add('Ouvert (0)'); // Tab opened
var tab_friends = meChatTab_Add('Amis'); // Tab friends
var tab_settings = meChatTab_Add('Options'); // Tab settings

meChat_Strings(
{
	box_menu_title: 'Messages (0)'
});

// Tab settings: Disable notifications
// Add item to tab
var tab_settings_item = meChatTab_AddItem(tab_settings,
	'<label><input type="checkbox" name="checkbox" value="value" ' + (meChatCookie_getProp('disable_notifications') ? 'checked' : '') + '> Désactiver notifications</label>'
);

// Add function to item (events: click, touchstart)
meChatTab_ItemFunction(tab_settings_item, 'click touchstart', function(itemID, itemDOM)
{
	$(this).find('label').trigger('click'); // Click in the checkbox

	// Alternate
	if (meChatCookie_getProp('disable_notifications') == true)
	{
		meChatCookie_setProp('disable_notifications', false);
	}
	else
	{
		meChatCookie_setProp('disable_notifications', true);
	}

	// Update item (checkbox)
	meChatTab_ItemHTML(itemID, '<label><input type="checkbox" name="checkbox" value="value" ' + (meChatCookie_getProp('disable_notifications') ? 'checked' : '') + '> Désactiver notifications</label>');

});

// Tab settings: Disable sounds
// Add item to tab
tab_settings_item = meChatTab_AddItem(tab_settings,
	'<label><input type="checkbox" name="checkbox" value="value" ' + (meChatCookie_getProp('disable_sounds') ? 'checked' : '') + '> Désactiver sons</label>'
);

// Add function to item (events: click, touchstart)
meChatTab_ItemFunction(tab_settings_item, 'click touchstart', function(itemID, itemDOM)
{
	$(this).find('label').trigger('click'); // Click in the checkbox

	// Alternate
	if (meChatCookie_getProp('disable_sounds') == true)
	{
		meChatCookie_setProp('disable_sounds', false);
	}
	else
	{
		meChatCookie_setProp('disable_sounds', true);
	}

	// Update item (checkbox)
	meChatTab_ItemHTML(itemID,
		'<label><input type="checkbox" name="checkbox" value="value" ' + (meChatCookie_getProp('disable_sounds') ? 'checked' : '') + '> Désactiver sons</label>'
	);

});

// When the chatbox is opened
meChat_Event('chat.open', function(chatID, chatDOM)
{

	// Build Item chatbox
	var me_chat_string = '';

	me_chat_string += '<div class="chatbox-menu-picture" style="background-image: url(' + meChat_getProp(chatID, 'picture') + ');"></div>';

	me_chat_string += '<div class="chatbox-menu-info"><div class="chatbox-menu-name">' + meChat_getProp(chatID, 'name') + '<br><i class="chatbox-menu-lastmessage"></i></div></div>';

	// Add item to tab (Opened)
	var itemID = meChatTab_AddItem(tab_opened, me_chat_string);

	// Add function to item   
	meChatTab_ItemFunction(itemID, 'click touchstart', function()
	{
		meChat_Open(chatID); // Open chatbox
		$('div[data-me-chat-id="' + chatID + '"]').find('textarea').focus(); // Search for chatbox with id and focus on it
	});

	// Sync item with the chatbox
	meChat_setProp(chatID, 'itemid', itemID);
});

// When the chatbox is closed
meChat_Event('chat.close', function(chatID, chatDOM, chatProp)
{
	// Remove synchronized item from tab (Opened)
	meChatTab_RemoveItem(chatProp.itemid);
});

// When the chatbox is closed, when sending message, when receiving message, and when click on the body of the chatbox
meChat_Event('chat.open chat.close chat.sendmessage chat.receivemessage chat.body.click', function(chatID, chatDOM, chatProp)
{
	meChatMenu_Title('Messages (' + meChat_unreadCount() + ')'); // Update the title of the chatboxes menu with the amount of unread messages

	meChatTab_Rename(tab_opened, 'Ouvert (' + (meChat_openedCount()) + ')'); // Update the tab (Opened) with the amount of open chatboxes

	// Update item of the tab (Opened)
	meChatTab_ItemHTML(chatProp.itemid,
		'<div class="chatbox-menu-picture" style="background-image: url(' + chatProp.picture + ');"></div><div class="chatbox-menu-info"><div class="chatbox-menu-name">' + chatProp.name + ' (' + chatProp.unread + ')<br><i class="chatbox-menu-lastmessage">' + chatProp.lastmessage + '</i></div></div>');
});

// Interval to update the tab (Friends)
setInterval(function()
{
	meChatTab_updateFriends(); // Call function
}, 60000); // Refresh every one minute, 60 seconds, 60.000 milliseconds

// Function to update the tab (Friends)
function meChatTab_updateFriends()
{
	$.ajax(
	{
		url: me_chat_settings.path + 'php/templates/developed.ajax.friendlist.php',
		type: 'POST',
		error: function() {},
		success: function(data)
		{
			data = JSON.parse(data);
			meChatTab_RemoveAllItem(tab_friends); // Remove all items from the tab (Friends)

			$.each(data, function(key, value)
			{ // Parse results of friends

				var me_chat_string = ''; // Store item HTML

				me_chat_string += '<div class="chatbox-menu-picture" style="background-image: url(' + value.friend_picture + ');"></div>';

				me_chat_string += '<div class="chatbox-menu-info chat-nospace"><div class="chatbox-menu-name">' + value.friend_name + '<br><i class="chatbox-menu-lastmessage"></i></div></div>';

				var me_chat_lastupdate = (meChat_timestamp() - value.friend_lastupdate); // Get the latest update in seconds

				if (me_chat_lastupdate < (2 * 60)) // Case be less than 2 minutes
				{
					me_chat_string += '<div class="chatbox-menu-status online">&bull;</div>';
				}

				if (me_chat_lastupdate > (2 * 60) && me_chat_lastupdate < (20 * 60)) // Case be more than 2 minutes
				{
					me_chat_string += '<div class="chatbox-menu-status">' + Math.round(me_chat_lastupdate / 60) + ' min' + '</div>'; // Example: 4 min (After conversion of seconds to minutes)
				}

				if (me_chat_lastupdate > (20 * 60)) // Case be more than 20 minutes
				{
					me_chat_string += '<div class="chatbox-menu-status offline">&bull;</div>';
				}

				// Add item to tab (Friends)
				var itemID = meChatTab_AddItem(tab_friends, me_chat_string);

				// Add function to item (event: click)
				meChatTab_ItemFunction(itemID, 'click', function()
				{
					meChat_Open(value.friend_id);
					$('div[data-me-chat-id="' + value.friend_id + '"]').find('textarea').focus();
				});
			});
		}
	});
}

// When the page is ready
$(document).ready(function()
{
    // Load cookies of meChat
    meChatCookie_Load();
    
	meChatMenu_Open(); // Open the chatboxes menu 
	meChatTab_Show(tab_friends); // Show tab (Friends)

	// Update tab (Friends)
	meChatTab_updateFriends();
});