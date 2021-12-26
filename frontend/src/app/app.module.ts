import { BrowserModule, Title } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { FormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { CommonModule } from '@angular/common';

import { AppComponent } from './app.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { AppRoutingModule } from './app-routing.module';
import { HomeComponent } from './home/home.component';
import { MaterialModule } from './material/material.module';
import { HeaderComponent } from './header/header.component';
import { RegisterComponent } from './register/register.component';
import { LoginComponent } from './login/login.component';
import { PageComponent } from './page/page.component';
import { FooterComponent } from './footer/footer.component';
import { LogoComponent } from './logo/logo.component';
import { AuthFormComponent } from './auth-form/auth-form.component';
import { FeedComponent } from './feed/feed.component';
import { AuthcheckComponent } from './authcheck/authcheck.component';
import { PageNotFoundComponent } from './page-not-found/page-not-found.component';
import { ProfileComponent } from './profile/profile.component';
import { AdminComponent } from './admin/admin.component';
import { ManageusersComponent } from './manageusers/manageusers.component';
import { SectionheaderComponent } from './sectionheader/sectionheader.component';
import { CreatenewpostComponent } from './createnewpost/createnewpost.component';
import { ManagepostsComponent } from './manageposts/manageposts.component';
import { ToastrModule } from 'ngx-toastr';

@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    HeaderComponent,
    RegisterComponent,
    LoginComponent,
    PageComponent,
    FooterComponent,
    LogoComponent,
    AuthFormComponent,
    FeedComponent,
    AuthcheckComponent,
    PageNotFoundComponent,
    ProfileComponent,
    AdminComponent,
    ManageusersComponent,
    SectionheaderComponent,
    CreatenewpostComponent,
    ManagepostsComponent,
  ],
  imports: [
    BrowserModule,
    CommonModule,
    BrowserAnimationsModule,
    ToastrModule.forRoot({
      positionClass: 'toast-top-center',
    }),
    FormsModule,
    AppRoutingModule,
    MaterialModule,
    HttpClientModule,
  ],
  providers: [Title],
  bootstrap: [AppComponent],
})
export class AppModule {}
