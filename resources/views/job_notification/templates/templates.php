<script id="jobNotificationTemplate" type="text/x-jsrender">
    <li class="media mt-4 notification rounded shadow p-4">
        <div class="form-group col-md-4 col-sm-12 mb-0 pt-1">
             <label class="form-check form-switch form-check-custom form-check-solid form-switch-sm">
                    <input type="checkbox" name="job_id[]" class="form-check-input notification__checkbox jobCheck" value="{{:job_id}}">
                        <span class="custom-switch-indicator"></span>
                            <a href="{{:jobDetails }}" target="_blank"
                               class="media-title mb-1 notification__title form-check-label ms-5 text-decoration-none">{{:job_title}}
                            </a>
            </label>
               <div class="text-time form-check-label ms-15">{{:created_by}}</div>
        </div>
    </li>
</script>
