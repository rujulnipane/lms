<div class="modal fade" id="uploadVideoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" id="uploadVideoForm">
                        <input type="hidden" id="sectionIdInput" name="sectionId">
                        <div class="mb-3">
                            <label for="videoFile" class="form-label">Choose Video File</label>
                            <input type="file" class="form-control" id="videoFile" name="videoFile" required accept="video/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>