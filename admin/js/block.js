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
        
        this.state = {
            key: 'referral_funnel_meta',
            refNo: wp.data.select('core/editor').getEditedPostAttribute('meta')[
                'referral_funnel_meta_refNo'
            ],
            listid: wp.data.select('core/editor').getEditedPostAttribute('meta')[
                'referral_funnel_meta_listid'
            ],
            workflowid: wp.data.select('core/editor').getEditedPostAttribute('meta')[
                'referral_funnel_meta_workflowid'
            ],
            workflowemailid: wp.data.select('core/editor').getEditedPostAttribute('meta')[
                'referral_funnel_meta_workflow_emailid'
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
                            label={__('MailChimp List ID where the subscribers will be added')}
                            value={this.state.listid}
                            onChange={(value) => {
                                this.setState({
                                    listid: value
                                }),
                                    wp.data.dispatch('core/editor').editPost({ meta: { referral_funnel_meta_listid: value } });
                            }}
                        />
                        <TextControl
                            label={__('MailChimp Workflow ID from Automation')}
                            value={this.state.workflowid}
                            onChange={(value) => {
                                this.setState({
                                    workflowid: value
                                }),
                                    wp.data.dispatch('core/editor').editPost({ meta: { referral_funnel_meta_workflowid: value } });
                            }}
                        />
                        <TextControl
                            label={__('MailChimp Workflow Email ID from Automation')}
                            value={this.state.workflowemailid}
                            onChange={(value) => {
                                this.setState({
                                    workflowemailid: value
                                }),
                                    wp.data.dispatch('core/editor').editPost({ meta: { referral_funnel_meta_workflow_emailid: value } });
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

