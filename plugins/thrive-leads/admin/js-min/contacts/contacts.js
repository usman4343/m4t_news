/*! Thrive Leads - The ultimate Lead Capture solution for wordpress - 2017-12-13
* https://thrivethemes.com 
* Copyright (c) 2017 * Thrive Themes */

!function(a){a(document).ready(function(){ThriveLeads.router.navigate("#contacts",{trigger:!0}),a(".tve-manager-download-button").on("click",function(){var b=a(this),c=b.parents(".tve-download-row").find(".tve-manager-source option:selected").val(),d=b.parents(".tve-download-row").find(".tve-manager-type option:selected").val(),e=a('<li class="tvd-collection-item"><div class="tvd-row"><div class="tvd-col tvd-s3"><span class="tvd-vertical-align">'+b.parents(".tve-download-row").find(".tve-manager-source option:selected").text()+'</span></div><div class="tvd-col tvd-s3"><span class="tvd-vertical-align">Now</span></div><div class="tvd-col tvd-s3 tve-status"><span class="tvd-vertical-align"><span class="tvd-vertical-align">Pending</span></span></div><div class="tvd-col tvd-s3 tve-action">'+a(".tve-pending-spinner").parent().html()+'</div></div></li>"'),f={start_date:a(".tve-contacts-start-date").val(),end_date:a(".tve-contacts-end-date").val(),source:a("#tve-contacts-source").val()};a(".tve-downloads-table .tvd-collection-header").after(e),a.ajax({method:"POST",url:ajaxurl,dataType:"json",data:{action:"thrive_leads_backend_ajax",route:"contacts",actionType:"download",source:c,type:d,params:f}}).done(function(a){e.find(".tve-status").html('<span class="tvd-vertical-align">'+a.response+"</span>"),e.find(".tve-action").empty().append('<div class="tvd-right"><a href="'+a.link+'" class="tvd-btn-icon tvd-btn-icon-green tvd-no-load tvd-tooltipped" data-tooltip="Download Report" data-position="top"><span class="tvd-icon-cloud-download"></span><span class="tvd-on-large-and-down">&nbsp;Download</span></a>&nbsp;<a data-id="'+a.id+'" class="tvd-btn-icon tvd-btn-icon-red tve-delete-download tvd-pointer tvd-tooltipped" data-tooltip="Delete Report" data-position="top"><span class="tvd-icon-delete2"></span><span class="tvd-on-large-and-down">&nbsp;Delete</span></a></div>')}).fail(function(a){500==a.status&&(e.find(".tve-status").html('<span class="tve-error">'+a.statusText+"</span>"),e.find(".tve-action").html("You might have a memory limit on your server. Please contact your host!"))})}),a(document).on("click",".tve-delete-download",function(){var b=a(this).attr("data-id"),c=a(this),d=c.parents("li.tvd-collection-item");c.parent().html(a(".tve-pending-spinner").parent().html()),a.ajax({method:"POST",url:ajaxurl,data:{id:b,action:"thrive_leads_backend_ajax",route:"contacts",actionType:"delete-download"}}).done(function(a){d.remove()})}),a(".tve-contacts-start-date").pickadate({format:"yyyy-mm-dd"}),a(".tve-contacts-end-date").pickadate({format:"yyyy-mm-dd"}),a(".tve-contacts-source").change(function(){a(".tve-contacts-source").val(a(this).val())}),a(".tve-contacts-per-page").change(function(){a(".tve-contacts-per-page").val(a(this).val())}),a("#ui-datepicker-div").hide(),a(".tvd-delete").click(function(b){return a("#tve-leads-delete-contact").openModal({out_duration:0,ready:function(){var c=b.currentTarget.href;a("#tve-leads-delete-contact .tve-modal-delete-contact").attr("href",c),a(document).on("keyup",function(b){13===b.which&&(TVE_Dash.showLoader(),a("#tve-leads-delete-contact").closeModal({out_duration:0}),window.location=c)})}}),!1}),a(".tve-email").click(function(){var b=a(this).attr("data-contact-id"),c=a("#tve-email-address"),d=a("#tve-save-email").is(":checked");""!=c.attr("data-default-value")?c.val(c.attr("data-default-value")).next().addClass("tvd-active"):d||c.val(""),a("#tve-contact-id").val(b),a("#tve-email-response").html("").removeClass(),a("#tve-email-lb").openModal({})}),a(".tve-send-email").click(function(){var b={id:a("#tve-contact-id").val(),save_email:a("#tve-save-email").is(":checked")?1:0,email_address:a("#tve-email-address").val()},c=a("#tve-email-response");if(""==b.email_address)return void c.html("Invalid Email.").removeClass().addClass("tve-error");a.ajax({method:"POST",url:ajaxurl,dataType:"json",data:{action:"thrive_leads_backend_ajax",route:"contacts",actionType:"send-email",data:b}}).done(function(a){c.html(a.response).removeClass().addClass("tve-"+a.type)})})})}(jQuery);