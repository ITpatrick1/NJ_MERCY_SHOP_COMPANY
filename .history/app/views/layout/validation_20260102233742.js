/**
 * Professional Form Validation System
 * Provides real-time validation, error handling, and user feedback
 */

// Validation Rules
const ValidationRules = {
  required: (value) => value.trim() !== '',
  email: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
  phone: (value) => /^0\d{9,10}$/.test(value),
  number: (value) => !isNaN(value) && value !== '',
  positiveNumber: (value) => !isNaN(value) && parseFloat(value) > 0,
  min: (value, min) => parseFloat(value) >= parseFloat(min),
  max: (value, max) => parseFloat(value) <= parseFloat(max),
  minLength: (value, length) => value.length >= length,
  maxLength: (value, length) => value.length <= length,
  pattern: (value, pattern) => new RegExp(pattern).test(value),
  alphanumeric: (value) => /^[a-zA-Z0-9\s]+$/.test(value),
  alpha: (value) => /^[a-zA-Z\s]+$/.test(value),
  date: (value) => !isNaN(Date.parse(value)),
  futureDate: (value) => new Date(value) >= new Date().setHours(0,0,0,0),
  pastDate: (value) => new Date(value) <= new Date(),
  tin: (value) => /^\d{9}$/.test(value) || value === '',
  password: (value) => value.length >= 6,
  strongPassword: (value) => /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(value),
  url: (value) => /^https?:\/\/.+/.test(value)
};

// Error Messages
const ErrorMessages = {
  required: 'This field is required',
  email: 'Please enter a valid email address',
  phone: 'Please enter a valid phone number (e.g., 0783086909)',
  number: 'Please enter a valid number',
  positiveNumber: 'Please enter a positive number',
  min: 'Value must be at least {min}',
  max: 'Value must not exceed {max}',
  minLength: 'Must be at least {length} characters',
  maxLength: 'Must not exceed {length} characters',
  pattern: 'Invalid format',
  alphanumeric: 'Only letters and numbers allowed',
  alpha: 'Only letters allowed',
  date: 'Please enter a valid date',
  futureDate: 'Date must be in the future',
  pastDate: 'Date must be in the past',
  tin: 'TIN must be 9 digits',
  password: 'Password must be at least 6 characters',
  strongPassword: 'Password must contain uppercase, lowercase, number and special character',
  url: 'Please enter a valid URL',
  match: 'Fields do not match'
};

// Validation Class
class FormValidator {
  constructor(formId, options = {}) {
    this.form = document.getElementById(formId);
    if (!this.form) return;
    
    this.options = {
      realTime: true,
      showSuccess: true,
      submitButton: null,
      onValidate: null,
      ...options
    };
    
    this.init();
  }
  
  init() {
    // Prevent default HTML5 validation
    this.form.setAttribute('novalidate', 'true');
    
    // Add event listeners
    if (this.options.realTime) {
      this.form.addEventListener('input', (e) => this.validateField(e.target));
      this.form.addEventListener('blur', (e) => this.validateField(e.target), true);
    }
    
    this.form.addEventListener('submit', (e) => this.handleSubmit(e));
  }
  
  validateField(field) {
    if (!field.name || field.type === 'submit' || field.type === 'button') return;
    
    const rules = this.getFieldRules(field);
    const errors = [];
    
    for (let rule of rules) {
      const [ruleName, ...params] = rule.split(':');
      const value = field.value;
      
      if (ruleName === 'required' && !ValidationRules.required(value)) {
        errors.push(ErrorMessages.required);
        break;
      }
      
      if (value && ValidationRules[ruleName]) {
        if (ruleName === 'match') {
          const matchField = document.querySelector(`[name="${params[0]}"]`);
          if (matchField && value !== matchField.value) {
            errors.push(ErrorMessages.match);
          }
        } else if (!ValidationRules[ruleName](value, ...params)) {
          let msg = ErrorMessages[ruleName] || ErrorMessages.pattern;
          // Replace placeholders with actual values
          if (ruleName === 'minLength' || ruleName === 'maxLength') {
            msg = msg.replace('{length}', params[0]);
          } else if (ruleName === 'min') {
            msg = msg.replace('{min}', params[0]);
          } else if (ruleName === 'max') {
            msg = msg.replace('{max}', params[0]);
          }
          errors.push(msg);
        }
      }
    }
    
    this.displayFieldError(field, errors);
    return errors.length === 0;
  }
  
  getFieldRules(field) {
    const rules = [];
    
    // Get from data-validate attribute
    if (field.dataset.validate) {
      rules.push(...field.dataset.validate.split('|'));
    }
    
    // HTML5 attributes
    if (field.hasAttribute('required')) rules.push('required');
    if (field.type === 'email') rules.push('email');
    if (field.type === 'number') rules.push('number');
    if (field.min) rules.push(`min:${field.min}`);
    if (field.max) rules.push(`max:${field.max}`);
    if (field.pattern) rules.push(`pattern:${field.pattern}`);
    if (field.minLength) rules.push(`minLength:${field.minLength}`);
    if (field.maxLength) rules.push(`maxLength:${field.maxLength}`);
    
    return rules;
  }
  
  displayFieldError(field, errors) {
    const wrapper = field.closest('.form-group, .col-md-6, .col-12, .input-group')?.parentElement || field.parentElement;
    let feedback = wrapper.querySelector('.invalid-feedback');
    
    if (!feedback) {
      feedback = document.createElement('div');
      feedback.className = 'invalid-feedback';
      if (field.closest('.input-group')) {
        field.closest('.input-group').after(feedback);
      } else {
        field.after(feedback);
      }
    }
    
    if (errors.length > 0) {
      field.classList.add('is-invalid');
      field.classList.remove('is-valid');
      feedback.textContent = errors[0];
      feedback.style.display = 'block';
    } else {
      field.classList.remove('is-invalid');
      if (this.options.showSuccess && field.value) {
        field.classList.add('is-valid');
      }
      feedback.style.display = 'none';
    }
  }
  
  handleSubmit(e) {
    let isValid = true;
    const fields = this.form.querySelectorAll('input, select, textarea');
    
    fields.forEach(field => {
      if (!this.validateField(field)) {
        isValid = false;
      }
    });
    
    if (!isValid) {
      e.preventDefault();
      e.stopPropagation();
      
      // Scroll to first error
      const firstError = this.form.querySelector('.is-invalid');
      if (firstError) {
        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        firstError.focus();
      }
      
      // Show error notification
      this.showNotification('Please fix the errors before submitting', 'error');
    } else if (this.options.onValidate) {
      const result = this.options.onValidate();
      if (result === false) {
        e.preventDefault();
      }
    }
    
    this.form.classList.add('was-validated');
  }
  
  showNotification(message, type = 'error') {
    // Create notification
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'error' ? 'danger' : 'success'} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);';
    notification.innerHTML = `
      <i class="fa fa-${type === 'error' ? 'exclamation-triangle' : 'check-circle'}"></i>
      <strong>${type === 'error' ? 'Error!' : 'Success!'}</strong> ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
      notification.remove();
    }, 5000);
  }
  
  reset() {
    this.form.reset();
    this.form.classList.remove('was-validated');
    this.form.querySelectorAll('.is-invalid, .is-valid').forEach(field => {
      field.classList.remove('is-invalid', 'is-valid');
    });
    this.form.querySelectorAll('.invalid-feedback').forEach(feedback => {
      feedback.style.display = 'none';
    });
  }
}

// Auto-initialize forms with data-validate-form attribute
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-validate-form]').forEach(form => {
    new FormValidator(form.id);
  });
});

// Export for use in modules
if (typeof module !== 'undefined' && module.exports) {
  module.exports = { FormValidator, ValidationRules, ErrorMessages };
}
