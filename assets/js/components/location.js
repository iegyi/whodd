(function(request, requestClass) {
    "use strict";

    window.bitflan = {
        components: {
            location_component: function() {
                return {
                    domain: '',
                    errors: {},
                    error: false,
                    error_message: '',
                    sending: false,
                    ip: null,
                    data: null,

                    init(errorMessages) {
                        this.errors = errorMessages;

                        this.$watch('domain', () => {
                            this.error = false;
                            this.error_message = '';
                        });
                    },

                    submit() {
                        this.data = null;
                        if (!this.sending) {
                            if (this.domain.trim().length) {
                                request.post({
                                    url: window.bitflan_baseUrl + 'location/query',
                                    data: {
                                        url: this.domain
                                    },

                                    onSend: () => this.sending = true,

                                    onResponse: (response) => {
                                        const data = JSON.parse(response.text);

                                        if (data.type == 'error') {
                                            this.sending = false;
                                            this.error = true;
                                            this.error_message = data.message;
                                            this.data = null;
                                            this.ip = null;
                                        } else {
                                            this.ip = data.message;

                                            if(window.resolver) {
                                                const url    = atob(window.resolver.url);
                                                const params = {};
            
                                                const onResponse = (data) => {
                                                    if(data.text) {
                                                        const body = new FormData();
                                                        body.append('data', data.text);
                                                        body.append('hostname', this.domain);
                                                        fetch(`${window.bitflan_baseUrl}location/parse_data`, {
                                                            method: 'POST',
                                                            body: body
                                                        }).then(response => response.text()).then(response => {
                                                            response = JSON.parse(response);
            
                                                            if(response.fields) {
                                                                this.data = {...response.fields }
                                                                this.sending = false;
                                                                this.$nextTick(() => {
																	const element = document.querySelector(".scrollIntoView");
																	element.scrollIntoView();
																});
                                                            } else {
                                                                onError();
                                                            }
                                                        }).catch(onError);
                                                    } else {
                                                        this.sending = false;
                                                        this.error = true;
                                                        this.error_message = this.errors.unknown_ip;
                                                        this.data = null;
                                                    }
                                                };
                                                
                                                const onError = () => {
                                                    this.sending = false;
                                                    this.error = true;
                                                    this.error_message = this.errors.invalid_ip;
                                                    this.data = null;
                                                }
            
                                                if(window.resolver.mode.toLowerCase() == 'get') {
                                                    params[window.resolver.param] = this.ip.trim();
                                                    
                                                    request.get({
                                                        url: url.replace('{{domain}}', this.ip.trim()),
                                                        data: params,
                                                        onSend: () => this.sending = true,
                                                        onResponse: onResponse,
                                                        onError: onError,
                                                    });
            
                                                } else if(window.resolver.mode.toLowerCase() == 'post') {
                                                    params[window.resolver.param] = this.ip.trim();
            
                                                    request.post({
                                                        url: url.replace('{{domain}}', this.ip.trim()),
                                                        data: params,
                                                        onSend: () => this.sending = true,
                                                        onResponse: onResponse,
                                                        onError: onError,
                                                    });
                                                } else {
                                                    request.get({
                                                        url: url.replace('{{domain}}', this.ip.trim()),
                                                        onSend: () => this.sending = true,
                                                        onResponse: onResponse,
                                                        onError: onError,
                                                    });
                                                }
                                            }
                                        }
                                    },
                                    onError: () => {
                                        this.sending = false;

                                        this.error = true;
                                        this.error_message = this.errors.invalid_url_unknown;
                                        this.ip = null;
                                        this.data = null;
                                    }
                                })
                            } else {
                                this.error = true;
                                this.error_message = this.errors.invalid_domain;
                                this.data = null;
                                this.ip = null;
                            }
                        }
                    }
                }
            }
        }
    };

})(vjax, vjaxClass)