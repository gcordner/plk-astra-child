console.log('Now is the time for all good men to come to the aid of the party.');

window.HUBBOX = {
  payload: {
    config: {
      altStateFormats: ['Alpha3'],
      retailerId: '9e986ee1-a1b7-4d0c-a30b-3f7de253cad1',
      selectors: {
        group: {
          selector: '#cfw-customer-info-address > h3',
          insertPosition: 'after'
        },
        search: {
          selector: undefined,
          insertPosition: 'before'
        },
        home: {
          selector: undefined,
          insertPosition: 'before'
        },
        inlineText: {
          orderId: '.woocommerce-order-overview__order > strong:nth-child(1)'
        },
        inputFields: {
          firstName: '#shipping_first_name',
          lastName: '#shipping_last_name',
          email: '#billing_email',
          address1: '#shipping_address_1',
          address2: '#shipping_address_2',
          other: undefined,
          city: '#shipping_city',
          country: '#shipping_country',
          company: '#shipping_company',
          county: '#shipping_state',
          postcode: '#shipping_postcode',
          telephone: '#billing_phone',
          phone2: undefined
        },
        shippingRates: {
          wrapper: '.woocommerce-shipping-methods',
          hiddenShippingRates: {
            ups: [
              'xpath://*[@id="shipping_method"]//li//label[contains(text(), "USPS")]/..',
            ],
          },
        }
      },
      urlRegex: {
        checkout: '^(?!.*received).*checkout.*$',
        confirmation: 'checkout.*received'
      },
      components: {
        network: 'ups',
        configId: 'ups_bridge',
        language: 'en-us',
        environment: 'production'
      },
      callbacks: {
        inputFieldsPopulated: (utils) => new Promise((resolve) => {
          utils.$('#ship-to-different-address-checkbox').input.checkbox.check();
          utils.$('.shipping_address').general.show();
          utils.$('#ship-to-different-address').general.hide();

          if (document.querySelector('#shipping_country')) {
            document.querySelector('#shipping_country').classList.remove('select2-hidden-accessible');
            if (document.querySelector('#shipping_country').nextSibling) {
              document.querySelector('#shipping_country').nextSibling.style.display = 'none';
            }

          }

          resolve();
        }),
        homeDeliveryWillUpdate: (utils, { launchSearchComponent, launchHomeComponent, launchGroupComponent, pickupConfirmationComponent }) => new Promise((resolve) => {
          launchSearchComponent.translations = { // Customization to look and feel can be done here, see web component docs in onboard
            'en-us': {
              'clickAndCollect': 'Pick Up Near You',
              'inputButtonAltText': 'Find a location',
              'chooseEnvironment': {
                'network': {
                  'ups': 'This option is best for the planet!',
                }
              }
            }
          };
          launchHomeComponent.translations = {
            'en-us': {
              homeDelivery: 'Ship to Address',
              select: {
                selectedState: {
                  active: 'Selected'
                }
              }
            }
          };
          pickupConfirmationComponent.translations = {
            'en-us': {
              'thankYou': {
                'network': {
                  'ups': 'Thank you for choosing greener shipping with UPS Access Points.'
                }
              },
              'orderWillBeSent': {
                'network': {
                  'ups': 'Your order will be sent to your chosen UPS Access Point. You will receive an email when your order is ready for collection.'
                }
              },
            }
          };
          console.log({ launchGroupComponent })
          launchGroupComponent.containerQueryOff = true;
          setTimeout(() => launchGroupComponent.style.setProperty('--hb-number-of-columns', 2), 0);
          launchGroupComponent.style.setProperty('--hb-number-of-columns', 2);
          resolve();
        }),
        homeDeliverySelected: (utils) => new Promise((resolve) => {
          const styles = `
        hb-core-pickup-confirmation::part(container) {
          display:none;
        }          
        `
          const styleSheet = document.createElement('style')
          styleSheet.innerText = styles
          document.head.appendChild(styleSheet)

          resolve();
        }),


        clickAndCollectSelected: (utils) => new Promise((resolve) => {
          const styles = `
        hb-core-pickup-confirmation::part(container) {
          display:block;
        }          
        `
          const styleSheet = document.createElement('style')
          styleSheet.innerText = styles
          document.head.appendChild(styleSheet)
        })


      },
      inputFieldsType: 'lock',
      logLevel: 'DEBUG'
    }
  }
};

// Web Component Styling
const styles = `
:root {
    --button-text-color: #ffffff;
    --button-letter-spacing: 0.5px;
    --button-text-transform: none;
    --button-font-size: 14px;
    --button-font-weight: 400;
    --button-background-color: #55761f;
    --button-border: none;
    --font-family: inherit;
    --title-text-color: #000000;
    --title-font-size: 16px;
    --title-font-weight: 700;
    --title-text-transform: none;
    --subtitle-text-color: #000000;
    --subtitle-font-size: 14px;
    --subtitle-text-transform: inherit;
    --border-radius: 5px;
    --border-color: rgb(204, 204, 204);
    --component-background-color: #ffffff;
}

hb-core-group::part(container) {
  display:flex;
  flex-direction: row-reverse;
}

hb-core-group::part(container) {
    display: flex;
    flex-direction: column-reverse;
    --hb-gap: 0.8em;
}

hb-core-home::part(container) {
    display: grid;
    grid-template-columns: 1fr 4fr 3fr;
    border: 0.02rem solid var(--border-color);
    width: 35rem;
    padding: 1.5rem;
    align-items: center;
    font-family: var(--font-family);
    min-width: -webkit-fill-available;
    border-radius: var(--border-radius);
    background: var(--component-background-color);
}

hb-core-home::part(container container-active) {
  border: 2px solid #55761f;
}  


hb-core-home::part(title) {
    grid-column: 2;
    font-size: var(--title-font-size);
    line-height: 1;
    font-weight: var(--title-font-weight);
    color: var(--title-text-color);
    margin-bottom: 0.6rem;
    text-transform: var(--title-text-transform);
}

hb-core-home::part(header-icon) {
    grid-column: 1;
    grid-row-start: 1;
    grid-row-end: 3;
    width: 3rem;
    height: 3rem;
  filter: invert(43%) sepia(10%) saturate(2783%) hue-rotate(41deg) brightness(90%) contrast(88%);
}

hb-core-home::part(subtitle) {
    grid-column: 2;
    line-height: 1;
    color: var(--subtitle-text-color);
    font-size: var(--subtitle-font-size);
    text-transform: var(--subtitle-text-transform);
}

hb-core-home::part(select-button) {
    grid-column: 3;
    grid-row-start: 1;
    grid-row-end: 3;
    border: var(--button-border);
    border-radius: 56px;
    width: 100%;
    height: 100%;
    background-color: var(--button-background-color);
    font-size: var(--button-font-size);
    color: var(--button-text-color);
    text-transform: var(--button-text-transform);
    letter-spacing: var(--button-letter-spacing);
    font-weight: var(--button-font-weight);
}

hb-core-search::part(container) {
    display: grid;
    grid-template-columns: 1fr 4fr 3fr;
    border: 0.02rem solid var(--border-color);
    width: 35rem;
    padding: 1.5rem;
    align-items: center;
    font-family: var(--font-family);
    min-width: -webkit-fill-available;
    border-radius: var(--border-radius);
    background: var(--component-background-color);
}

hb-core-search::part(container container-active) {
  border: 2px solid #55761f;
}

hb-core-search::part(title) {
    grid-column: 2;
    font-size: var(--title-font-size);
    line-height: 1;
    font-weight: var(--title-font-weight);
    color: var(--title-text-color);
    margin-bottom: 0.6rem;
    text-transform: var(--title-text-transform);
}

hb-core-search::part(title-icon) {
    grid-column: 1;
    grid-row-start: 1;
    grid-row-end: 3;
    width: 3rem;
    height: 3rem;
  background-image: url('https://cdn.hub-box.com/widget-assets/images/icons/hw-pin-ups.svg');
  background-position-x: center;
}

hb-core-search::part(subtitle) {
    grid-column: 2;
    line-height: 1;
    color: var(--subtitle-text-color);
    font-size: var(--subtitle-font-size);
    text-transform: var(--subtitle-text-transform);
    color: #55761f;
    font-weight: 600;
}

hb-core-search::part(search-button) {
    grid-column: 3;
    grid-row-start: 1;
    grid-row-end: 3;
    border: var(--border-color);
    border-radius: 56px;
    width: 100%;
    height: 100%;
    background-color: var(--button-background-color);
    font-size: var(--button-font-size);    
    color: var(--button-text-color);
    text-transform: var(--button-text-transform);
    letter-spacing: var(--button-letter-spacing);
    font-weight: var(--button-font-weight);    
}

hb-core-pickup-confirmation::part(container) {
    border: 0.1rem solid var(--border-color);
    max-width: 45rem;
    padding: 2rem;
    font-family: var(--font-family);
    min-width: -webkit-fill-available;
    border-radius: var(--border-radius);
    background: var(--component-background-color);
    margin-bottom: 30px;
}

hb-core-pickup-confirmation::part(title) {
    font-size: var(--title-font-size);
    font-weight: var(--title-font-weight);
    color: var(--title-text-color);
    margin-bottom: 0.6rem;
    text-transform: var(--title-text-transform);
}

hb-core-pickup-confirmation::part(subtitle) {
    border-bottom: 0.08rem solid #e6e6e6;
    padding-bottom: 1rem;
    font-size: var(--subtitle-font-size);
    color: var(--subtitle-text-color);
    text-transform: var(--subtitle-text-transform);
}

hb-core-pickup-confirmation::part(collect-point-wrapper) {
    display: grid;
    grid-gap: 0.5rem 0;
    grid-template-columns: auto auto;
    grid-template-rows: auto auto auto;
    padding-top: 1rem;
    color: var(--subtitle-text-color);
}

hb-core-pickup-confirmation::part(address) {
    grid-column: 1;
    grid-row-start: 1;
    grid-row-end: 2;
    font-size: var(--subtitle-font-size);
    color: var(--subtitle-text-color);
}

hb-core-pickup-confirmation::part(find-collect-point-button) {
    grid-column: 1;
    grid-row-start: 3;
    grid-row-end: 4;
    text-decoration: underline;
    padding: 0;
    border: 0;
    background: transparent;
    text-align: left;
    line-height: inherit;
    font-size: var(--subtitle-font-size);
    color: var(--subtitle-text-color);
}

hb-core-pickup-confirmation::part(opening-times) {
    display: grid;
    grid-template-columns: max-content 1fr;
    grid-auto-rows: max-content;
    grid-gap: 0 1rem;
    grid-column: 1;
    grid-row-start: 2;
    grid-row-end: 3;
    text-transform: var(--subtitle-text-transform);
    font-size: var(--subtitle-font-size);
    color: var(--subtitle-text-color);
}

hb-core-pickup-confirmation::part(map) {
    grid-column-start: 2;
    grid-column-end: 3;
    grid-row-start: 1;
    grid-row-end: 4;
    margin-left: auto;
}
`
const styleSheet = document.createElement('style')
styleSheet.innerText = styles
document.head.appendChild(styleSheet)

(function (d, script) {
  script = d.createElement('script');
  script.type = 'text/javascript';
  script.async = true;
  script.onload = function () {
    // remote script has loaded
  };
  script.src = 'https://cdn.hub-box.com/tag-payload/1.9.2/tag-payload.iife.js';
  d.getElementsByTagName('head')[0].appendChild(script);
}(document));