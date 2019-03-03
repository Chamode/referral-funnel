/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var __ = wp.i18n.__;
var _wp$element = wp.element,
    Component = _wp$element.Component,
    Fragment = _wp$element.Fragment;

var compose = wp.element.compose;
var _wp$editPost = wp.editPost,
    PluginSidebar = _wp$editPost.PluginSidebar,
    PluginSidebarMoreMenuItem = _wp$editPost.PluginSidebarMoreMenuItem;
var registerPlugin = wp.plugins.registerPlugin;
var _wp$components = wp.components,
    PanelBody = _wp$components.PanelBody,
    TextControl = _wp$components.TextControl,
    CheckboxControl = _wp$components.CheckboxControl;
var _wp$data = wp.data,
    withSelect = _wp$data.withSelect,
    withDispatch = _wp$data.withDispatch;

var Referral_Funnel = function (_Component) {
    _inherits(Referral_Funnel, _Component);

    function Referral_Funnel() {
        _classCallCheck(this, Referral_Funnel);

        var _this = _possibleConstructorReturn(this, (Referral_Funnel.__proto__ || Object.getPrototypeOf(Referral_Funnel)).apply(this, arguments));

        _this.state = {
            key: 'referral_funnel_meta',
            refNo: wp.data.select('core/editor').getEditedPostAttribute('meta')['referral_funnel_meta_refNo'],
            listid: wp.data.select('core/editor').getEditedPostAttribute('meta')['referral_funnel_meta_listid'],
            workflowid: wp.data.select('core/editor').getEditedPostAttribute('meta')['referral_funnel_meta_workflowid'],
            workflowemailid: wp.data.select('core/editor').getEditedPostAttribute('meta')['referral_funnel_meta_workflow_emailid']

        };
        return _this;
    }

    _createClass(Referral_Funnel, [{
        key: 'render',
        value: function render() {
            var _this2 = this;

            return wp.element.createElement(
                Fragment,
                null,
                wp.element.createElement(
                    PluginSidebarMoreMenuItem,
                    {
                        target: 'referral-funnel-sidebar'
                    },
                    __('Referral Funnel Admin')
                ),
                wp.element.createElement(
                    PluginSidebar,
                    {
                        name: 'referral-funnel-sidebar',
                        title: __('Referral Funnel Admin')
                    },
                    wp.element.createElement(
                        PanelBody,
                        null,
                        wp.element.createElement(TextControl, {
                            label: __('Number of Referrals'),
                            value: this.state.refNo,
                            onChange: function onChange(value) {
                                _this2.setState({
                                    refNo: value
                                }), wp.data.dispatch('core/editor').editPost({ meta: { referral_funnel_meta_refNo: value } });
                            }
                        }),
                        wp.element.createElement(TextControl, {
                            label: __('MailChimp List ID where the subscribers will be added'),
                            value: this.state.listid,
                            onChange: function onChange(value) {
                                _this2.setState({
                                    listid: value
                                }), wp.data.dispatch('core/editor').editPost({ meta: { referral_funnel_meta_listid: value } });
                            }
                        }),
                        wp.element.createElement(TextControl, {
                            label: __('MailChimp Workflow ID from Automation'),
                            value: this.state.workflowid,
                            onChange: function onChange(value) {
                                _this2.setState({
                                    workflowid: value
                                }), wp.data.dispatch('core/editor').editPost({ meta: { referral_funnel_meta_workflowid: value } });
                            }
                        }),
                        wp.element.createElement(TextControl, {
                            label: __('MailChimp Workflow Email ID from Automation'),
                            value: this.state.workflowemailid,
                            onChange: function onChange(value) {
                                _this2.setState({
                                    workflowemailid: value
                                }), wp.data.dispatch('core/editor').editPost({ meta: { referral_funnel_meta_workflow_emailid: value } });
                            }
                        })
                    )
                )
            );
        }
    }]);

    return Referral_Funnel;
}(Component);

registerPlugin('hello-gutenberg', {
    icon: 'admin-site',
    render: Referral_Funnel
});

/***/ })
/******/ ]);