<?php
namespace Drupal\describe_site\Form;

// Classes referenced in this class:
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;

// This is the form we are extending
use Drupal\system\Form\SiteInformationForm;

/**
 * Configure site information settings for this site.
 */
class DescribeSiteSiteInformationForm extends SiteInformationForm
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        // Retrieve the system.site configuration
        $site_config = $this->config('system.site');

        // Get the original form from the class we are extending
        $form = parent::buildForm($form, $form_state);

        // Add a textarea to the site information section of the form for our
        // description
        $form['site_information']['site_description'] = [
          '#type' => 'textarea',
          '#title' => t('Site description'),
          // The default value is the new value we added to our configuration
          // in step 1
          '#default_value' => $site_config->get('description'),
          '#description' => $this->t('The description of the site'),
        ];
    
        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        // Now we need to save the new description to the
        // system.site.description configuration.
        $this->config('system.site')
            // The site_description is retrieved from the submitted form values
            // and saved to the 'description' element of the system.site configuration
            ->set('description', $form_state->getValue('site_description'))
            // Make sure to save the configuration
            ->save();

        // Pass the remaining values off to the original form that we have extended,
        // so that they are also saved
        parent::submitForm($form, $form_state);
    }
}
?>