<?php
//shepherd test
?>
<html>
<head>
<script src="../js/shepherd.min.js"></script>
<link rel="stylesheet" type="text/css" href="../css/shepherd.css" />
</head>
<body>

<script>
const tour = new Shepherd.Tour({
  defaultStepOptions: {
    classes: 'shadow-md bg-purple-dark',
    scrollTo: true
  }
});

tour.addStep({
  id: 'example-step',
  text: 'This step is attached to the bottom of the <code>.example-css-selector</code> element.',
  attachTo: {
    element: '.example-css-selector',
    on: 'bottom'
  },
  classes: 'example-step-extra-class',
  buttons: [
    {
      text: 'Next',
      action: tour.next
    }
  ]
});
</script>
</body>
</html>