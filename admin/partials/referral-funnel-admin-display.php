<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       example.com
 * @since      1.0.0
 *
 * @package    Referral_Funnel
 * @subpackage Referral_Funnel/admin/partials
 */

function referral_funnel_admin_display()
{

    ?>
<div id="app" >
    <v-app id="inspire" >
        <v-card-title>
     <span  class="title"> Referral Funnel Dashboard </span>
      
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="search"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
    </v-card-title>
          <v-layout v-resize="onResize" column>
            <v-data-table :headers="headers" :items="user_info" :search="search" :pagination.sync="pagination" :hide-headers="isMobile" :class="{mobile: isMobile}">
              <template slot="items" slot-scope="props">
                <tr v-if="!isMobile">
                  <td>{{ props.item.display_name}} </td>
                  <td class="text-xs-center">{{ props.item.user_email }}</td>
                  <td class="text-xs-center">{{ props.item.reflink }}</td>
                  <td class="text-xs-center">{{ props.item.rf_postTitle }}</td>
                  <td class="text-xs-center">{{ props.item.rf_current_email_id }}</td>
                  <td class="text-xs-center">{{ props.item.refcount }}</td>
                  <td class="text-xs-center">{{ props.item.currprogress }}</td>
                  <td class="text-xs-center">
                
                        <v-icon
                          medium
                          color= "red"
                          @click="deleteItem(props.item)"
                          >
                          block
                        </v-icon>
                      
               
                </td>
                </tr>
                <tr v-else>
                  <td>
                    <ul class="flex-content">
                      <li class="flex-item" data-label="Name">{{ props.item.data.display_name}}</li>
                      <li class="flex-item" data-label="User Email">{{ props.item.data.user_email }}</li>
                      <li class="flex-item" data-label="Referral Link">{{ props.item.meta.refllink[0] }}</li>
                      <li class="flex-item" data-label="Current Post">{{ props.item.meta.rf_postTitle[0] }}</li>
                      <li class="flex-item" data-label="Email ID">{{ props.item.meta.rf_current_email_id[0] }}</li>
                      <li class="flex-item" data-label="Total Invites">{{ props.item.totalinvited }}</li>
                      <li class="flex-item" data-label="Current Progress">{{ props.item.currprogress }}</li>
                      <td class="justify-center layout px-30">
                          <v-icon
                            large = "true"
                            @click="deleteItem(props.item)"
                          >
                          delete
                        </v-icon>
                      </td>

                    </ul>
                  </td>
                </tr>
              </template>
              <v-alert slot="no-results" :value="true" color="error" icon="warning">
                Your search for "{{ search }}" found no results.
              </v-alert>
            </v-data-table>
          </v-layout>
    </v-app>

  </div>

<?php

}
?>
