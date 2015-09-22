/**
 * Enables desired notification methods with multiple XHR requests
 *
 * This add a UI that can be used to force desired notification methods
 * for all users.
 */
define(function(require) {
	/**
	 * Process a batch of users
	 *
	 * @param {Int} offset
	 * @param {String} operation
	 */
	processBatch = function(offset, operation) {
		var options = {
			data: {
				offset: offset
			},
			dataType: 'json'
		};

		options.data = elgg.security.addToken(options.data);
		options.success = function(json) {
			if (json.output.count) {
				var oldValue = $('#progressbar-' + operation).progressbar("value");
				var newValue = oldValue + offset;

				processBatch(offset + 10, operation);
			} else {
				newValue = 100;
			}

			$('#progressbar-' + operation).progressbar({value: newValue});
		};

		var action = 'action/notification_tools/enable_' + operation;
		elgg.post(action, options);
	};

	/**
	 * Trigger one of the bulk operations
	 *
	 * @param {Object} e
	 */
	enable = function(e) {
		e.preventDefault();

		// TODO Get the desired notification methods from the form
		processBatch(0, this.dataset.operation);
	};

	$(document).on('click', '#enable-personal', enable);
	$(document).on('click', '#enable-collection', enable);
	$(document).on('click', '#enable-group', enable);

	$('.elgg-progressbar').each(function (key, value) {
		$(this).progressbar({
			value: 0,
			total: this.dataset.total
		});
	});
});
