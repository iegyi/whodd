(function(request, requestClass) {
    "use strict";

    function isValidIP(str) {
        const regexExp = /^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/gi;
        return regexExp.test(str);
    }

    window.bitflan = {
        components: {
            ip_lookup_component: function() {
                return {
                    domain: '',
                    errors: {},
                    error: false,
                    error_message: '',
                    sending: false,
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
                            if (this.domain.trim().length && isValidIP(this.domain.trim())) {

                                if (window.resolver) {
                                    const url = atob(window.resolver.url);
                                    const params = {};

                                    const onResponse = (data) => {
                                        if (data.text) {
                                            const body = new FormData();

                                            body.append('data', data.text);

                                            fetch(`${window.bitflan_baseUrl}ip_lookup/parse_data`, {
                                                method: 'POST',
                                                body: body
                                            }).then(response => response.text()).then(response => {
                                                response = JSON.parse(response);

                                                if (response.fields) {
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

                                    if (window.resolver.mode.toLowerCase() == 'get') {
                                        params[window.resolver.param] = this.domain.trim();

                                        request.get({
                                            url: url.replace('{{domain}}', this.domain.trim()),
                                            data: params,
                                            onSend: () => this.sending = true,
                                            onResponse: onResponse,
                                            onError: onError,
                                        });

                                    } else if (window.resolver.mode.toLowerCase() == 'post') {
                                        params[window.resolver.param] = this.domain.trim();

                                        request.post({
                                            url: url.replace('{{domain}}', this.domain.trim()),
                                            data: params,
                                            onSend: () => this.sending = true,
                                            onResponse: onResponse,
                                            onError: onError,
                                        });
                                    } else {
                                        request.get({
                                            url: url.replace('{{domain}}', this.domain.trim()),
                                            onSend: () => this.sending = true,
                                            onResponse: onResponse,
                                            onError: onError,
                                        });
                                    }
                                }
                            } else {
                                this.error = true;
                                this.error_message = this.errors.invalid_ip;
                                this.data = null;
                            }
                        }
                    }
                }
            }
        }
    };

})(vjax, vjaxClass)