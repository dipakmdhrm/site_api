Site API Key

This module alters the existing Drupal "Site Information" form.

Specifics:

1. A new form text field named "Site API Key" is added to the "Site Information" form with the default value of “No API Key yet”. The value for this field is saved as the system variable named "siteapikey".
2. This module also provides a URL that responds with a JSON representation of a given node with the content type "page" only if the previously submitted API Key and a node id (nid) of an appropriate node are present, otherwise it will respond with "access denied".
