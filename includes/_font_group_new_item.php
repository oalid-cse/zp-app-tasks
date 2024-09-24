<div id="hidden-item" class="d-none">
    <div id="groupItem">
        <div class="font-group-item">
            <div class="form-group font-list">
                <label class="form-label">Select Fonts</label>
                <select class="form-select fontSelect" name="font_ids[]" required
                        onchange="selectGroupFont(this)"></select>
            </div>
            <div class="form-group font-name">
                <label class="form-label">Font Name</label>
                <input type="text" class="form-control font-name" disabled>
            </div>
            <div class="action">
                <button type="button" class="font-group-item-delete" onclick="deleteGroupItem(this)">
                    X
                </button>
            </div>
        </div>
    </div>
</div>
