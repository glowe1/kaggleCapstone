# Contributing to Edmond Serenity

## Development Guidelines

### Code Standards

1. **Follow Laravel Best Practices**
   - Use Eloquent ORM for database operations
   - Follow PSR-12 coding standards
   - Use dependency injection
   - Keep controllers thin, use service classes

2. **Filament Resources**
   - All forms MUST use Filament resources
   - View pages should display data in infolist style (not forms)
   - No Blade files for view pages

3. **UI/UX Consistency**
   - Use the custom color scheme on all pages
   - Include project favicon on all UI pages
   - Maintain consistent button styling (like user card buttons)
   - Keep a consistent look across all UI components

### Git Workflow

1. **Branching Strategy**
   ```bash
   main - production-ready code
   develop - integration branch
   feature/* - new features
   bugfix/* - bug fixes
   hotfix/* - urgent production fixes
   ```

2. **Commit Messages**
   ```
   feat: Add medication administration workflow
   fix: Resolve vitals validation issue
   docs: Update API documentation
   refactor: Optimize resident query performance
   test: Add unit tests for medication service
   ```

3. **Pull Requests**
   - Create PR from feature branch to develop
   - Include description of changes
   - Reference related tasks from PROJECT_PLAN.md
   - Ensure all tests pass
   - Request code review

### Development Process

1. **Starting a New Feature**
   ```bash
   git checkout develop
   git pull origin develop
   git checkout -b feature/medication-workflow
   ```

2. **During Development**
   - Write tests for new functionality
   - Update documentation as needed
   - Follow the sprint plan in PROJECT_PLAN.md
   - Check off completed tasks

3. **Before Committing**
   - Run tests: `php artisan test`
   - Check code style: `./vendor/bin/pint`
   - Ensure no linter errors
   - Review your changes

4. **Submitting Work**
   ```bash
   git add .
   git commit -m "feat: Add medication administration workflow"
   git push origin feature/medication-workflow
   # Create pull request on GitHub/GitLab
   ```

### Testing Requirements

1. **Unit Tests**
   - Test all service classes
   - Test model relationships
   - Test validation rules

2. **Feature Tests**
   - Test complete user workflows
   - Test API endpoints
   - Test authorization

3. **Browser Tests**
   - Test critical user journeys
   - Test mobile responsiveness
   - Test offline functionality

### Code Review Checklist

- [ ] Code follows Laravel conventions
- [ ] All tests pass
- [ ] No linter errors
- [ ] Documentation updated
- [ ] UI matches design guidelines
- [ ] Mobile responsive
- [ ] Accessible (WCAG compliance)
- [ ] No security vulnerabilities
- [ ] Performance optimized
- [ ] Error handling implemented

### Database Migrations

1. **Creating Migrations**
   ```bash
   php artisan make:migration create_residents_table
   ```

2. **Migration Best Practices**
   - Always include `down()` method
   - Use descriptive names
   - Add foreign key constraints
   - Include indexes for performance
   - Follow schema in DATABASE_SCHEMA.md

3. **Running Migrations**
   ```bash
   # Development
   php artisan migrate
   
   # Production (with backup)
   php artisan migrate --force
   ```

### Filament Development

1. **Creating Resources**
   ```bash
   php artisan make:filament-resource Resident --generate
   ```

2. **Resource Structure**
   - Use form builder for create/edit
   - Use infolist for view pages
   - Include table filters
   - Add bulk actions where appropriate
   - Implement search functionality

3. **Custom Pages**
   ```bash
   php artisan make:filament-page Dashboard
   ```

### Environment Setup

1. **Required PHP Extensions**
   - BCMath
   - Ctype
   - Fileinfo
   - JSON
   - Mbstring
   - OpenSSL
   - PDO
   - Tokenizer
   - XML

2. **Development Tools**
   - Laravel Debugbar (development)
   - Laravel Telescope (debugging)
   - Laravel Pint (code formatting)
   - PHPUnit (testing)

### Security Guidelines

1. **Authentication**
   - Use Laravel Sanctum
   - Implement rate limiting
   - Enforce strong password policies

2. **Authorization**
   - Use Laravel policies
   - Implement role-based access control
   - Validate all user inputs

3. **Data Protection**
   - Encrypt sensitive data
   - Use HTTPS in production
   - Implement CSRF protection
   - Sanitize all outputs

### Performance Optimization

1. **Database**
   - Use eager loading to prevent N+1 queries
   - Add appropriate indexes
   - Use database transactions
   - Implement query caching

2. **Frontend**
   - Lazy load images
   - Minimize JavaScript bundles
   - Use asset versioning
   - Implement browser caching

3. **Backend**
   - Cache frequently accessed data
   - Use queue jobs for slow operations
   - Optimize file uploads
   - Implement response caching

### Documentation

1. **Code Documentation**
   - Use PHPDoc for all methods
   - Explain complex logic
   - Document API endpoints

2. **User Documentation**
   - Update user guides
   - Create video tutorials
   - Maintain FAQ

### Support

For questions or assistance:
- Review PROJECT_PLAN.md for task details
- Check DATABASE_SCHEMA.md for schema reference
- Consult Laravel documentation
- Consult Filament documentation

---

## Sprint Checklist

Before marking a sprint complete:
- [ ] All sprint tasks completed
- [ ] Tests written and passing
- [ ] Documentation updated
- [ ] Code reviewed and approved
- [ ] Deployed to staging
- [ ] User acceptance testing completed
- [ ] Performance benchmarks met
- [ ] Security review completed

