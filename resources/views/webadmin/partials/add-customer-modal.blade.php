<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModal" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">New Customer</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="row">
              <div class="col-lg-6 mb-3">
                <label class="form-label">Customer Name</label>
                <input type="text" class="form-control" placeholder="Enter full name">
              </div>
              <div class="col-lg-6 mb-3">
                <label class="form-label">Email Address</label>
                <input type="text" class="form-control" placeholder="Enter email">
              </div>
              <div class="col-lg-6 mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" class="form-control" placeholder="e.g. +1 234 567 8900">
              </div>
              <div class="col-lg-6 mb-3">
                <label class="form-label">Company</label>
                <input type="text" class="form-control" placeholder="Company name">
              </div>
              <div class="col-lg-6 mb-3">
                <label class="form-label">Country</label>
                <select class="form-select">
                  <option value="">Select country</option>
                  <option value="US">United States</option>
                  <option value="UK">United Kingdom</option>
                  <option value="IN">India</option>
                  <option value="CA">Canada</option>
                  <option value="DE">Germany</option>
                  <option value="FR">France</option>
                  <option value="JP">Japan</option>
                  <option value="BR">Brazil</option>
                  <option value="EG">Egypt</option>
                </select>
              </div>
              <div class="col-lg-6 mb-3">
                <label class="form-label">Customer Type</label>
                <select class="form-select">
                  <option value="">Select type</option>
                  <option value="Lead">Lead</option>
                  <option value="Prospect">Prospect</option>
                  <option value="Client">Client</option>
                </select>
              </div>
              <div class="col-lg-6 mb-3">
                <label class="form-label">Account Status</label>
                <select class="form-select">
                  <option value="">Select status</option>
                  <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
                  <option value="Blocked">Blocked</option>
                </select>
              </div>
              <div class="col-lg-6 mb-3">
                <label class="form-label">Joined Date</label>
                <input type="text" class="form-control flatpickr-date" readonly="readonly">
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary ms-2">Add Customer</button>
          </div>
        </div>
      </div>
    </div>
