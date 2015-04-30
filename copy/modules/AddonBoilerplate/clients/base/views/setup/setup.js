

({
    className: 'addonboilerplate-setup',
    currentStep: 1,

    events: 
    {
        'click .nextStep':'nextStep',
        'click .previousStep':'previousStep',
        'click .goToStep':'goToStep',
        'click .testLogin':'testLogin',
        'click .checkScheduler':'checkScheduler',
        'click .saveConfiguration':'saveConfiguration',
        'click .setupComplete':'setupComplete',
        'click .howtoListToggleLink':'howtoListToggleLink',
    },
    initialize: function(opts) {
        app.alert.dismissAll();
        Handlebars.registerPartial('setup.header', app.template.get('setup.header.AddonBoilerplate'));
        Handlebars.registerPartial('setup.footer', app.template.get('setup.footer.AddonBoilerplate'));
        app.view.View.prototype.initialize.call(this, opts);

        this.setStep(1);
    },    
    _render: function () {
        app.view.View.prototype._render.call(this);

        //initialize any data is required for this step
        if(this.steps[this.currentStep].initializeStep) {
            this.steps[this.currentStep].initializeStep();
        } else {
            this.initializeStep();
        }
        
        //update display for current step
        $('#addonboilerplate-setup-status').html(this.steps[this.currentStep].message);

        $('.setup-steps a.current span').removeClass('badge-inverse');
        $('.setup-steps a.current').removeClass('current');
        $('#addonboilerplate-setup-step'+this.getCurrentStep()).addClass('current');
        $('.setup-steps a.current span').addClass('badge-inverse');
        
        return this;
    },
    setStep: function(step) {
        this.currentStep = step;
        this.template = app.template.getView('setup.step'+this.currentStep, 'AddonBoilerplate');
        
        if (!this.template) {
            app.error.handleRenderError(this, 'view_render_denied');
        }
    },
    previousStep: function(e) {
        if (this.isFirstStep()) return;
        
        if(this.steps[this.currentStep].previousStep) {
            this.setStep(this.steps[this.currentStep].previousStep(e));
        } else {
            this.setStep(this.currentStep - 1);
        }
        
        this.render();
    },
    nextStep: function(e) {
        if (this.isLastStep()) return;
        
        if(this.steps[this.currentStep].nextStep) {
            this.setStep(this.steps[this.currentStep].nextStep(e));
        } else {
            this.setStep(this.currentStep + 1);
        }
        
        this.render();
    },
    goToStep: function(e) {
        var $currentTarget = $(e.currentTarget);

        this.setStep($currentTarget.data('step'));
        this.render();
    },
    getCurrentStep: function() {
        
        if(this.steps[this.currentStep].getCurrentStep) {
            return this.steps[this.currentStep].getCurrentStep();
        } else {
            return this.currentStep;
        }
    },
    isFirstStep: function() {
        if(this.steps[this.currentStep].isFirstStep) {
            return this.steps[this.currentStep].isFirstStep();
        } else {
            return (this.currentStep <= 1);
        }
    },
    isLastStep: function() {
        if(this.steps[this.currentStep].isLastStep) {
            return this.steps[this.currentStep].isLastStep();
        } else {
            return (this.currentStep == Object.keys(this.steps).length);
        }
    },
    initializeStep: function() {
    },
    setupComplete: function() {
        //redirect to somewhere that gets the user using the add-on immediately
        //for this example we are just going to go to the home page
        app.router.navigate('#Home', {trigger: true});
    },
    steps: {
        1 : {
            message : "Welcome to AddonBoilerplate! Let's get started below...",
            initializeStep : function() {
                app.alert.dismissAll();
                app.alert.show('AddonBoilerplate_loading', {level: 'process', title: 'LBL_LOADING', autoClose: false});

                var callbacks = {
                        success: function(data,response) {
                            app.alert.dismiss('AddonBoilerplate_loading');
                            if (!data.apikey){
                                data.apikey = '';
                            }
                            $('#apikey').val(data.apikey);
                        }
                    };

                app.api.call('GET', app.api.buildURL('AddonBoilerplate/apikey'), {}, callbacks, {});
            }
        },
        2 : {
            message : "Next up...setting up your sync schedule",
            initializeStep : function() {
                app.alert.show('AddonBoilerplate_loading', {level: 'process', title: app.lang.get('STATUS_CONFIRMING_SCHEDULER', 'AddonBoilerplate'), autoClose: false});

                var callbacks = {
                        success: function(data,response) {
                            app.alert.dismiss('AddonBoilerplate_loading');
                            
                            $('.setup-processing').hide();
                            $('.setup-success').hide();
                            $('.setup-fail').hide();
                            $('.setup-ondemand').hide();
                            
                            if(!data.ondemand) {
                                $('.scheduler-realpath').html(data.realpath);
                                if(data.is_windows) {
                                    $('#scheduler-setup-linux').hide();
                                    $('#scheduler-setup-windows').show();
                                } else {
                                    $('#scheduler-setup-windows').hide();
                                    $('#scheduler-setup-linux').show();
                                }

                                if(data.scheduler_ran) {
                                    $('.setup-success').show();
                                } else {
                                    $('.setup-fail').show();
                                }
                            } else {
                                $('.setup-ondemand').show();
                            }
                        }
                    };

                app.api.call('GET', app.api.buildURL('AddonBoilerplate/scheduler'), {}, callbacks, {});
            }
        },
        3 : {
            message : "Getting closer...now set some meaningless configurations",
            nextStep : function(e) {
                var $currentTarget = $(e.currentTarget);
                
                var customNextStep = $currentTarget.data('nextstep');
                if (customNextStep == undefined) {
                    return 4;
                } else {
                    return customNextStep;
                }
            },
            initializeStep : function() {
                app.alert.show('AddonBoilerplate_loading', {level: 'process', title: app.lang.get('STATUS_CONNECTING_TO_XYZ', 'AddonBoilerplate'), autoClose: false});

                var callbacks = {
                        success: function(data,response) {
                            app.alert.dismiss('AddonBoilerplate_loading');
                            
                            if(data.success) {
                                $('#my_config').val(data.value);
                            } else {
                                var errorMessages = [app.lang.get('ERR_TRY_AGAIN', 'AddonBoilerplate')];
                                if(data.message) {
                                    errorMessages.push('<br/><br/>');
                                    errorMessages.push(data.message);
                                }
                                app.alert.show('AddonBoilerplate_save_error', {
                                    level: 'error',
                                    title: app.lang.get('ERR_INTEGRATION_CONNECTION', 'AddonBoilerplate'),
                                    messages: errorMessages,
                                    autoClose: false
                                });
                            }
                        }
                    };
                    
                app.api.call('GET', app.api.buildURL('AddonBoilerplate/setting/my_config'), {}, callbacks, {});
            }
        },
        4 : {
            message : "That is it...enjoy!",
            getCurrentStep : function() { return 4; },
            initializeStep : function() {
            }
        }

    },

    checkScheduler : function() {

    },
    testLogin : function() {
        app.alert.dismissAll();
        $('#apikey-group').removeClass('error');
        $('#apikey-group .help-block').hide();
        
        app.alert.show('AddonBoilerplate_save_inprocess', {level: 'process', title: 'LBL_PROCESSING_REQUEST', autoClose: false});
        
        //check to see if apikey is set
        var apikey = $('#apikey').val();
        if(!$.trim(apikey).length) {
            app.alert.show('AddonBoilerplate_validation_error', {
                level: 'error',
                title: app.lang.get('ERR_NO_APIKEY_TITLE', this.module),
                messages: [app.lang.get('ERR_NO_APIKEY', this.module)],
                autoClose: false
            });
            
            $('#apikey-group').addClass('error');
            $('#apikey-group .help-block').show();
            return;
        }
        
        var self = this;
        var payload = {
                apikey: apikey
            },
            callbacks = {
                success: function(data,response) {
                    app.alert.dismiss('AddonBoilerplate_save_inprocess');
                    if(data.success) {
                        app.alert.show('AddonBoilerplate_save_success', {
                            level: 'info',
                            title: app.lang.get('SUCCESS_LOGIN_TEST_TITLE', self.module),
                            messages: [app.lang.get('SUCCESS_LOGIN_TEST', self.module)],
                            autoClose: true
                        });

                        //move on to next step
                        self.nextStep();
                    } else {
                        var errorMessages = [app.lang.get('ERR_LOGIN_TEST', self.module)];
                        if(data.message) {
                            errorMessages.push('<br/><br/>');
                            errorMessages.push(data.message);
                        }
                        app.alert.show('AddonBoilerplate_save_error', {
                            level: 'error',
                            title: app.lang.get('ERR_LOGIN_TEST_TITLE', self.module),
                            messages: errorMessages,
                            autoClose: false
                        });

                        app.logger.error('Failed to save the api key. ' + error);
                    }
                }
            };

        app.api.call('create', app.api.buildURL('AddonBoilerplate/apikey/update'), payload, callbacks, {});
    },
    saveConfiguration: function(e) {
        app.alert.show('AddonBoilerplate_save_inprocess', {level: 'process', title: 'LBL_SAVING', autoClose: false});
        
        app.api.call('create', app.api.buildURL('AddonBoilerplate/setting/my_config/'+$('#my_config').val()), {}, {
            success: _.bind(function(o) {
                app.alert.dismiss('AddonBoilerplate_save_inprocess');

                app.alert.show('AddonBoilerplate_save_success', {
                    level: 'info',
                    title: app.lang.get('SUCCESS_CONFIGURATION_TITLE', this.module),
                    messages: [app.lang.get('SUCCESS_CONFIGURATION', this.module)],
                    autoClose: true
                });
                        
                //move on to next step
                this.nextStep(e);
            }, this)
        });
    },
    howtoListToggleLink: function() {
        $('.howtoListToggle').toggle();
    }
        
})
