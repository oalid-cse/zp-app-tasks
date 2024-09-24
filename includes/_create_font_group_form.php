<div class="card mt-4 createFontGroupCard" id="createFontGroupCard">
    <div class="card-header">
        <h5 class="card-title">
            Create Font Group
        </h5>
        <div class="tools">
            <button type="button" class="btn back-to-create d-none" onclick="backToCreateFontGroup()">Back To Create</button>
        </div>
    </div>
    <div class="card-body">
        <form id="fontGroupForm">
            <div class="mb-3">
                <label for="groupName" class="form-label">Group Name</label>
                <input type="text" class="form-control" id="groupName" name="name" required>
            </div>
            <div class="font-group-item-wrapper">

            </div>

            <div class="d-flex justify-content-between">
                <button type="button" onclick="addGroupItem()" class="btn btn-outline-success">Add Row</button>
                <button type="submit" class="btn btn-success fontGroupCreateBtn">Create</button>
            </div>
        </form>
    </div>
</div>
