/**
 * @author Matheus Gontijo <matheus@matheusgontijo.com>
 */

/**
 * =============================
 * ========== BASE
 * =============================
 */

var Base = Base || {};

Base = {
	redirect: function (url) {
		window.location.href = url;
	},

	showAjaxResponseErrors: function(data) {
		var msg = '';

		$(data.errors).each(function(index, value) {
			msg += value + "\n";
		});

		alert(msg);
	}
}


/**
 * =============================
 * ========== POST VOTE
 * =============================
 */

var PostVote = PostVote || {};

PostVote = {
	vote: function(postId, userId) {
		if (typeof currentUserId == 'undefined') {
			Base.redirect('/user/login');
			return;
		}

		if (userId == currentUserId) {
			return;
		}

		var item = $('#post-upvote-' + postId);

		if (!item.hasClass('active')) {
			item.addClass('active');

			item.html(
				parseInt(item.html()) + 1
			);

			$.ajax({
				url  : '/post-vote/create',
				type : 'post',
				data : {
					post_id : postId
				},
				done: function() {
					// @TODO: do something
				}
			});
		} else {
			item.removeClass('active');

			item.html(
				parseInt(item.html()) - 1
			);

			$.ajax({
				url  : '/post-vote/delete',
				type : 'post',
				data : {
					post_id : postId
				},
				done: function() {
					// @TODO: do something
				}
			});
		}
	},

	updateItemsVoted: function(userId) {
		var postIds = [];

		$('input[name="post_id[]"]').each(function() {
			postIds.push($(this).val());
		});

		var obj = this;

		$.ajax({
			url  : '/post-vote.php',
			type : 'post',
			data : {
				post_ids : postIds,
				user_id  : userId
			},
			success: function(data) {
				obj.updateItemVoted(data);
			},
			error: function() {

			}
		});
	},

	updateItemVoted: function(data) {
		$(data.data).each(function(index, item) {
			$('#post-upvote-' + item)
				.addClass('active');
		});
	}
}


/**
 * =============================
 * ========== SEARCH
 * =============================
 */

var Search = Search || {};

Search = {
	init: function () {
		var obj = this;

		$('#search').keyup(function(e){
			if (e.keyCode == 13) {
				obj.submit();
			}
		});
	},

	submit: function () {
		Base.redirect('/search/' + $('#search').val());
	}
}
