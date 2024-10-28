// Tender management class
class TenderManager {
    constructor() {
        this.initializeElements();
        this.initializeEventListeners();
        this.initializeComponents();
    }

    initializeElements() {
        this.searchInput = document.getElementById('searchInput');
        this.searchButton = document.getElementById('searchButton');
        this.startDate = document.getElementById('startDate');
        this.endDate = document.getElementById('endDate');
        this.companySearchInput = document.querySelector('.dropdown-menu input[placeholder="Search companies..."]');
        this.qrButtons = document.querySelectorAll('.show-qr-code');
        this.printQrButton = document.getElementById('printQrCode');
    }

    initializeEventListeners() {
        // Search handlers
        this.searchInput?.addEventListener('keyup', this.handleSearch.bind(this));
        this.searchButton?.addEventListener('click', () => this.performSearch());

        // Filter handlers
        document.getElementById('applyDateFilter')?.addEventListener('click', this.applyFilters.bind(this));
        document.getElementById('applyStatusFilter')?.addEventListener('click', this.applyFilters.bind(this));
        document.getElementById('applyCompanyFilter')?.addEventListener('click', this.applyFilters.bind(this));

        // QR Code handlers
        this.qrButtons.forEach(button => {
            button.addEventListener('click', this.handleQrCode.bind(this));
        });
        this.printQrButton?.addEventListener('click', this.printQrCode.bind(this));

        // Company search
        this.companySearchInput?.addEventListener('input', this.handleCompanySearch.bind(this));

        // Card hover effects
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mouseenter', () => card.classList.add('shadow-lg'));
            card.addEventListener('mouseleave', () => card.classList.remove('shadow-lg'));
        });

        // Initialize Select All Companies button
        if (this.companySearchInput) {
            this.initializeSelectAllButton();
        }
    }

    initializeComponents() {
        // Initialize Bootstrap components
        this.initializeBootstrapComponents();
        // Update active filters on page load
        this.updateActiveFilters();
    }

    handleSearch(e) {
        clearTimeout(this.searchTimeout);
        if (e.key === 'Enter') {
            this.performSearch();
        } else {
            this.searchTimeout = setTimeout(() => this.performSearch(), 500);
        }
    }

    performSearch() {
        const searchTerm = this.searchInput.value;
        window.location.href = `${routes.tenders.index}?search=${encodeURIComponent(searchTerm)}`;
    }

    applyFilters() {
        const params = new URLSearchParams(window.location.search);
        
        // Date filters
        if (this.startDate.value) params.set('start_date', this.startDate.value);
        if (this.endDate.value) params.set('end_date', this.endDate.value);

        // Status filter
        const status = document.querySelector('input[name="status"]:checked').value;
        if (status !== 'all') params.set('status', status);

        // Company filters
        const selectedCompanies = Array.from(document.querySelectorAll('.company-filter:checked'))
            .map(checkbox => checkbox.value);
        if (selectedCompanies.length) params.set('companies', selectedCompanies.join(','));

        window.location.href = `${routes.tenders.index}?${params.toString()}`;
    }

    async handleQrCode(e) {
        e.preventDefault();
        const tenderId = e.currentTarget.dataset.id;
        const modal = new bootstrap.Modal(document.getElementById('qrCodeModal'));
        const container = document.getElementById('qrCodeContainer');

        container.innerHTML = this.getLoadingSpinner();
        modal.show();

        try {
            const response = await fetch(`${routes.tenders.qrcode.replace(':id', tenderId)}`);
            const html = await response.text();
            container.innerHTML = html;
        } catch (error) {
            container.innerHTML = this.getErrorMessage();
        }
    }

    printQrCode() {
        const content = document.getElementById('qrCodeContainer').innerHTML;
        const printWindow = window.open('', '', 'width=600,height=600');
        printWindow.document.write(this.getPrintTemplate(content));
    }

    handleCompanySearch(e) {
        const searchTerm = e.target.value.toLowerCase();
        const checkboxes = e.target.closest('.dropdown-menu').querySelectorAll('.form-check');
        
        checkboxes.forEach(checkbox => {
            const label = checkbox.querySelector('label').textContent.toLowerCase();
            checkbox.style.display = label.includes(searchTerm) ? '' : 'none';
        });
    }

    initializeSelectAllButton() {
        const selectAllBtn = document.createElement('button');
        selectAllBtn.className = 'btn btn-sm btn-light w-100 mb-2';
        selectAllBtn.textContent = 'Select All';
        this.companySearchInput.parentNode.insertBefore(selectAllBtn, this.companySearchInput);

        selectAllBtn.addEventListener('click', this.handleSelectAll.bind(this));
    }

    handleSelectAll(e) {
        const checkboxes = e.target.closest('.dropdown-menu').querySelectorAll('.company-filter');
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        checkboxes.forEach(cb => cb.checked = !allChecked);
    }

    updateActiveFilters() {
        const activeFiltersContainer = document.createElement('div');
        activeFiltersContainer.className = 'active-filters mt-3';
        let hasActiveFilters = false;

        // Add date range filter
        if (this.startDate.value && this.endDate.value) {
            hasActiveFilters = true;
            activeFiltersContainer.appendChild(
                this.createActiveFilter(
                    `Date: ${this.startDate.value} to ${this.endDate.value}`,
                    'date-range'
                )
            );
        }

        // Add status filter
        const selectedStatus = document.querySelector('input[name="status"]:checked');
        if (selectedStatus?.value !== 'all') {
            hasActiveFilters = true;
            activeFiltersContainer.appendChild(
                this.createActiveFilter(
                    `Status: ${selectedStatus.value}`,
                    'status'
                )
            );
        }

        // Add company filters
        document.querySelectorAll('.company-filter:checked').forEach(company => {
            hasActiveFilters = true;
            activeFiltersContainer.appendChild(
                this.createActiveFilter(
                    `Company: ${company.nextElementSibling.textContent.trim()}`,
                    `company-${company.value}`
                )
            );
        });

        if (hasActiveFilters) {
            this.appendActiveFilters(activeFiltersContainer);
        }
    }

    createActiveFilter(text, value) {
        const filter = document.createElement('span');
        filter.className = 'badge bg-primary me-2 mb-2';
        filter.innerHTML = `
            ${text}
            <button type="button" class="btn-close btn-close-white ms-2" 
                    data-value="${value}" aria-label="Remove"></button>
        `;
        return filter;
    }

    appendActiveFilters(container) {
        const clearAllBtn = document.createElement('button');
        clearAllBtn.className = 'btn btn-sm btn-light ms-2';
        clearAllBtn.innerHTML = '<i class="fas fa-times me-1"></i>Clear All';
        clearAllBtn.addEventListener('click', this.clearAllFilters.bind(this));
        container.appendChild(clearAllBtn);

        const filtersSection = document.querySelector('.card-body');
        const existingFilters = filtersSection.querySelector('.active-filters');
        if (existingFilters) {
            existingFilters.remove();
        }
        filtersSection.appendChild(container);
    }

    clearAllFilters() {
        this.startDate.value = '';
        this.endDate.value = '';
        document.querySelector('input[value="all"]').checked = true;
        document.querySelectorAll('.company-filter').forEach(cb => cb.checked = false);
        this.updateActiveFilters();
        this.applyFilters();
    }

    initializeBootstrapComponents() {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => 
            new bootstrap.Tooltip(el)
        );
        document.querySelectorAll('[data-bs-toggle="popover"]').forEach(el => 
            new bootstrap.Popover(el)
        );
    }

    getLoadingSpinner() {
        return `
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        `;
    }

    getErrorMessage() {
        return `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>
                Error loading QR code
            </div>
        `;
    }

    getPrintTemplate(content) {
        return `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Print QR Code</title>
                <style>
                    body { 
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        min-height: 100vh;
                        margin: 0;
                    }
                    .qr-container {
                        text-align: center;
                        padding: 20px;
                    }
                </style>
            </head>
            <body>
                <div class="qr-container">${content}</div>
                <script>
                    window.onload = function() {
                        window.print();
                        window.setTimeout(function() {
                            window.close();
                        }, 250);
                    };
                </script>
            </body>
            </html>
        `;
    }
}

// Routes configuration
const routes = {
    tenders: {
        index: '/tenders',
        qrcode: '/tenders/:id/qrcode'
    }
};

// Initialize on DOM load
document.addEventListener('DOMContentLoaded', () => {
    new TenderManager();
});