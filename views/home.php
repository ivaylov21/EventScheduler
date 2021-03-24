<?php
session_start();
require_once("../controllers/events/EventController.php");	
if (!isset($_SESSION["user_id"]) || !$_SESSION["user_id"]) {
	header("Location: http://localhost/EventScheduler/index.php");
}

use controllers\events\EventController;

$controller = new EventController();
$events = $controller->getAllEvents();
$controller->closeConnection();

require("../includes/header.php");
?>

<div class="container">
  <ul class="nav justify-content-end">
    <li class="nav-item">
      <a class="nav-link" href="http://localhost/EventScheduler/views/logout.php">Logout</a>
    </li>
  </ul>
	<div class="row event-actions">
		<div class="col-md-12">
			<button id="addEventBtn" type="button" data-toggle="modal" data-target="#addEventModal" class="btn btn-success">Add Event</button>
		</div>
	</div>
  <div class="row">
    <div class="input-group mb-3 col-md-6">
      <input id="filterName" type="text" class="form-control" placeholder="Filter by name">
    </div>
  </div>
	<div class="row">
		<table id="eventsTable" class="table">
			<thead class="thead-dark">
			<tr>
			  <th scope="col" class="cell-center">Name</th>
			  <th scope="col" class="cell-center">Priority</th>
			  <th scope="col" class="cell-center">Description</th>
			  <th scope="col" class="cell-center">User</th>
        <th scope="col" class="cell-center">Actions</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach($events as $event) {?>
				<tr id="<?=$event->id ?>" class="records">
				  <td class="cell-center" id="<?=$event->id ?>-name"><?=$event->name ?></td>
				  <td class="cell-center" id="<?=$event->id ?>-priority"><?=$event->priority ?></td>
				  <td class="cell-center" id="<?=$event->id ?>-description"><?=$event->description ?></td>
				  <td class="cell-center" id="<?=$event->id ?>-user"><?=$event->user_full_name ?></td>
          <td>
            <?php if ($event->user_id == $_SESSION["user_id"]) {?>
            <div class="btn-group action-buttons" role="group">
              <button type="button" class="btn btn-dark edit-event">Edit</button>
              <button type="button" class="btn btn-danger delete-event">Delete</button>
            </div>
            <?php }?>
          </td>
				</tr>
			<?php }?>
			</tbody>
		</table>
    <div id="error" class="alert alert-danger hidden" role="alert"></div>
	</div>
</div>
<div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventLabel" aria-hidde="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addEventLabel">New event</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addEventForm">
          <div class="form-group">
            <label for="name" class="col-form-label">Name</label>
            <input type="text" class="form-control" id="name">
          </div>
          <div class="form-group">
            <label for="priority">Priority</label>
            <select class="form-control" id="priority">
              <?php foreach ($EVENT_PRIORITY_CHOICES as $key=>$val) {?>
                <option value="<?=$key?>"><?=$val?></option>
              <?php }?>
            </select>
          </div>
          <div class="form-group">
            <label for="description" class="col-form-label">Description:</label>
            <textarea class="form-control" id="description"></textarea>
          </div>
          <div id="error" class="alert alert-danger hidden" role="alert"></div>
          <input class="hidden" type="text" id="editedEvent" name="edit">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" form="addEventForm" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>
</body>
<script src="../static/js/home.js"></script>
</html>