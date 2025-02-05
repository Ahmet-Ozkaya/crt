/** @format */

// Force 24-hour format for time inputs
document.addEventListener("DOMContentLoaded", function () {
  const timeInputs = document.querySelectorAll('input[type="time"]');

  timeInputs.forEach((input) => {
    // Set step to 1 minute for better precision
    input.step = 60;

    // Add event listener to validate format
    input.addEventListener("change", function () {
      const timePattern = /^(0[7-9]|1[0-8]):[0-5]0$/;
      const timeValue = this.value;

      if (!timePattern.test(timeValue)) {
        this.setCustomValidity(
          "Please enter time between 07:00-18:00 in 10-minute intervals"
        );
      } else {
        const [hours, minutes] = timeValue.split(":").map(Number);
        if (hours < 7 || hours > 18 || (hours === 18 && minutes > 0)) {
          this.setCustomValidity("Time must be between 07:00 and 18:00");
        } else {
          this.setCustomValidity("");
        }
      }
      this.reportValidity();
    });
  });
});
