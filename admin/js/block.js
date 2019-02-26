const { __ } = wp.i18n;

const { Component, Fragment } = wp.element;
var compose = wp.element.compose;
const {
    PluginSidebar,
    PluginSidebarMoreMenuItem,
} = wp.editPost;

const { registerPlugin } = wp.plugins;

const {
    PanelBody,
    TextControl,
    CheckboxControl  
} = wp.components;

const { withSelect, withDispatch } = wp.data;

class Referral_Funnel extends Component {
    constructor() {
        super(...arguments);
        var ftypeCon = wp.data.select('core/editor').getEditedPostAttribute('meta')[
            'referral_funnel_meta_ftype'] === "" ? false : wp.data.select('core/editor').getEditedPostAttribute('meta')[
            'referral_funnel_meta_ftype'];
        this.state = {
            key: 'referral_funnel_meta',
            ftype: ftypeCon,

            refNo: wp.data.select('core/editor').getEditedPostAttribute('meta')[
                'referral_funnel_meta_refNo'
            ],
            mailChimp: wp.data.select('core/editor').getEditedPostAttribute('meta')[
                'referral_funnel_meta_mailChimp'
            ],
           
        }
        console.log(this.state.ftype)
    }

    render() {

        return (
            <Fragment>
                <PluginSidebarMoreMenuItem
                    target="referral-funnel-sidebar"
                >
                    {__('Referral Funnel Admin')}
                </PluginSidebarMoreMenuItem>
                <PluginSidebar
                    name="referral-funnel-sidebar"
                    title={__('Referral Funnel Admin')}
                >
                    <PanelBody>

                        <CheckboxControl
                            label="Funnel Beginning"
                            checked={this.state.ftype}
                            onChange={(isChecked) => {
                                this.setState({ ftype: isChecked }),
                                wp.data.dispatch('core/editor').editPost({ meta: { referral_funnel_meta_ftype: isChecked } });
                            }}
                        />
                        <TextControl
                            label={__('Number of Referrals')}
                            value={this.state.refNo}
                            onChange={(value) => {
                                this.setState({
                                    refNo: value
                                }),
                                    wp.data.dispatch('core/editor').editPost({ meta: { referral_funnel_meta_refNo: value } });
                            }}
                        />
                        <TextControl
                            label={__('MailChimp Campaign Name')}
                            value={this.state.mailChimp}
                            onChange={(value) => {
                                this.setState({
                                    mailChimp: value
                                }),
                                    wp.data.dispatch('core/editor').editPost({ meta: { referral_funnel_meta_mailChimp: value } });
                            }}
                        />
                    </PanelBody>
                </PluginSidebar>
            </Fragment>
        )
    }
}

registerPlugin('hello-gutenberg', {
    icon: 'admin-site',
    render: Referral_Funnel,
});

