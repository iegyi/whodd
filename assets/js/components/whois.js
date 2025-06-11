(function(request, requestClass) {
    "use strict";

    window.bitflan = {
        components: {
            whois_component: function() {
                return {
                    domain: '',
                    errors: {},
                    error: false,
                    error_message: '',
                    sending: false,

                    init(domain, errorMessages, error = false) {
                        this.errors = errorMessages;

                        this.$watch('domain', () => {
                            if (error) {
                                this.error = true;
                                this.error_message = error;
                            } else {
                                this.error = false;
                                this.error_message = '';
                            }
                        });

                        if (domain) {
                            this.domain = domain;
                            this.$nextTick(() => {
								let element;
								if(element = document.querySelector(".scrollIntoView")) {
									element.scrollIntoView();
								}
							});
                        }
                    },

                    domain_check() {
                        return true
                    },

                    get_bool(dmn, cb) {
                        const fd = new FormData();

                        fd.append('domain', dmn);

                        fetch(window.bitflan_baseUrl + 'whois/bool', {
                            method: 'POST',
                            body: fd
                        }).then(res => res.text()).then(text => {
                            cb(text);
                        });
                    },

                    submit() {
                        this.data = null;
                        if (this.domain_check()) {
                            this.error = false;
                            this.error_message = '';
                            this.sending = true;

                            let domain = this.domain.toLowerCase();

                            if (domain.includes('://'))
                                domain = domain.split('://')[1];

                            window.location.replace(`${window.bitflan_baseUrl}whois/${domain.trim()}`);
                        } else {
                            this.error = true;
                            this.error_message = this.errors.invalid_domain;
                        }
                    }
                }
            }
        }
    };

})(vjax, vjaxClass)