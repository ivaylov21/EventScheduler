$(document).ready(function() {
	$("#addEventForm").on("submit", function(e) {
		e.preventDefault();

		var name = $("#name").val();
		var priority = $("#priority").val();
		var description = $("#description").val();
        var editId = $("#editedEvent").val();

		$.ajax({
            url: window.location.origin + '/EventScheduler/middleware/add_event.php',
            method: 'POST',
            data: {
                name: name,
                priority: priority,
                description: description,
                editId: editId
            },
            success: function(response) {
                if (response.success) {
                	$("#addEventModal").modal("hide");
                    window.location.reload();
                } else {
                    var errorDiv = $("#error");
                    errorDiv.removeClass("hidden");
                    errorDiv.text(response.error);
                }
            }
        })
	});

	$(document).on("click", ".edit-event", function(e) {
        var editId = $(e.target).closest("tr").attr("id");

        var name = $("#name");
        var priority = $("#priority");
        var description = $("#description");
        var editedEvent = $("#editedEvent");

        name.val($("#" + editId + "-name").text());
        priority.val($("#" + editId + "-priority").text());
        description.val($("#" + editId + "-description").text());
        editedEvent.val(editId);

        $("#addEventModal").modal();
    });

    $(document).on("click", ".delete-event", function(e) {
        var eventId = $(e.target).closest("tr").attr("id");
 
        $.ajax({
            url: window.location.origin + '/EventScheduler/middleware/delete_event.php',
            method: 'POST',
            data: {
                id: eventId
            },
            success: function(response) {
                if (response.success) {
                    window.location.reload();
                } else {
                    var errorDiv = $("#error");
                    errorDiv.removeClass("hidden");
                    errorDiv.text(response.error);
                }
            }
        })
    });

    $(document).on("change", "#filterName", function(e) {
        var filteredName = $(e.target).val();
 
        $.ajax({
            url: window.location.origin + '/EventScheduler/middleware/filter_events.php',
            method: 'GET',
            data: {
                filter: filteredName
            },
            success: function(response) {
                if (response.success) {
                    $(".records").remove();
                    var html = '';
                    response.events.forEach(function(event) {
                    	html += '<tr class="records" id="' + event.id + '">' +
	                    			'<td class="cell-center" id="' + event.id + '-name">' + event.name + '</td>' + 
	                    			'<td class="cell-center" id="' + event.id + '-priority">' + event.priority + '</td>' +
	                    			'<td class="cell-center" id="' + event.id + '-description">' + event.description + '</td>' +
	                    			'<td class="cell-center" id="' + event.id + '-user">' + event.user_full_name + '</td>' +
	                    			'<td>';
	                    if (response.userId == event.user_id) {
	                    	html += '<div class="btn-group action-buttons" role="group">' +
              							'<button type="button" class="btn btn-dark edit-event">Edit</button>' +
              							'<button type="button" class="btn btn-danger delete-event">Delete</button>' +
        							'</div>';
	                    }
	                    html += '</td></tr>';	
                    });
                    var elem = $.parseHTML(html);
                    $('tbody').append(elem);
                } else {
                    var errorDiv = $("#error");
                    errorDiv.removeClass("hidden");
                    errorDiv.text(response.error);
                }
            }
        })
    });
});