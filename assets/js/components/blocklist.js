(function(request, requestClass, $) {
    "use strict";

    window.bitflan = {
        components: {
            blocklist_component: function() {
                return {
                    data: null,
                    domain: '',
                    url: '',
                    errors: {},
                    error: false,
                    error_message: '',
                    sending: false,
                    status: 'blank',
                    others_render: null,
                    suggestions_render: null,

                    init(errorMessages) {
                        this.errors = errorMessages;
                        this.$watch('domain', () => {
                            this.error = false;
                            this.error_message = '';
                        });
                    },

                    singleQuery(url) {
                        return new Promise((resolve, reject) => {
                            const req = new vjaxClass();

                            req.post({
                                url: window.bitflan_baseUrl + 'blocklist_lookup/single_query',
                                data: {
                                    url: url,
                                    domain: this.domain
                                },

                                onResponse: (response) => {
                                    resolve(JSON.parse(response.text));
                                },
                                onError: (err) => console.error(err)
                            })
                        });
                    },
                    submit() {
                        this.data = null;
                        this.domain = '';
                        this.url = '';
                        this.errors = {};
                        this.error = false;
                        this.error_message = '';
                        this.max_per_page = 200;
                        this.sending = false;
                        this.status = 'blank';
                        this.others_render = null;
                        this.suggestions_render = null;
                        if($('#resultcontent').hasClass('result-content')) {
                            $('#resultcontent').removeClass('result-content');
                        }
                        if (!this.sending) {
                            this.domain = document.getElementById("inputboxvalue").value;
                            if (this.domain.trim().length) {
                                request.post({
                                    url: window.bitflan_baseUrl + 'blocklist_lookup/query',
                                    data: {
                                        url: this.domain,
                                    },

                                    onSend: () => {
                                        this.sending = true;
                                        this.others_render = [];
                                        this.suggestions_render = [];
                                        this.status = 'blank';
                                    },

                                    onResponse: (response) => {
                                            const data = JSON.parse(response.text);
                                            this.sending = false;
                                            if (data.type == 'error') {
                                                this.error = true;
                                                this.error_message = data.message;
                                                this.others_render = [];
                                                this.suggestions_render = [];
                                                this.status = 'blank';
                                            } else {
                                                if(!$('#resultcontent').hasClass('result-content')) {
                                                    $('#resultcontent').addClass('result-content');
                                                }
                                                this.domain = data.domain;
                                                const midIndex = Math.floor(data.other_tlds.length / 2);
                                                this.others_render = data.other_tlds.slice(0, midIndex);
                                                this.suggestions_render = data.other_tlds.slice(midIndex);
                                            }
                                    },
                                    onError: () => {
                                        if($('#resultcontent').hasClass('result-content')) {
                                            $('#resultcontent').removeClass('result-content');
                                        }
                                        this.sending = false;
                                        this.error = true;
                                        this.error_message = this.errors.invalid_url_unknown;
                                        this.others_render = [];
                                        this.suggestions_render = [];
                                        this.status = 'blank';
                                    }
                                })
                            } else {
                                if($('#resultcontent').hasClass('result-content')){
                                    $('#resultcontent').removeClass('result-content');
                                }
                                this.sending = false;
                                this.others_render = [];
                                this.suggestions_render = [];
                            }
                        }
                    }
                }
            }
        }
    };
})(vjax, vjaxClass, jQuery)