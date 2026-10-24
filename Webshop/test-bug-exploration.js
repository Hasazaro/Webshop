/**
 * Bug Condition Exploration Test for Webshop Critical Fixes
 * 
 * **Validates: Requirements 2.1, 2.2, 2.3, 2.4, 2.5, 2.6, 2.7, 2.8, 2.9, 2.10**
 * 
 * CRITICAL: This test MUST FAIL on unfixed code - failure confirms the bug exists
 * DO NOT attempt to fix the test or the code when it fails
 * 
 * Property 1: Bug Condition - Professional Navigation and Functionality Test
 * 
 * This test encodes the expected behavior and will validate the fix when it passes after implementation.
 * GOAL: Surface counterexamples that demonstrate the bugs exist
 */

const fs = require('fs');
const path = require('path');

// Test configuration
const testConfig = {
    baseUrl: 'http://localhost/webshop',
    files: {
        indexHtml: 'index.html',
        indexPhp: 'index.php', 
        categoriesPhp: 'Categories.php',
        groentenPhp: 'groenten.php',
        drinkenPhp: 'drinken.php',
        broodPhp: 'brood.php',
        spicesPhp: 'spices.php',
        productsPhp: 'products.php',
        productsHtml: 'products.html',
        cartPhp: 'inkelwagen .php', // Note: space in filename is intentional bug
        mainJs: 'main.js',
        styleCss: 'style.css'
    }
};

/**
 * Bug Condition Test Suite
 * Tests that will FAIL on unfixed code, confirming bugs exist
 */
function runBugConditionTests() {
    const testResults = {
        totalTests: 8,
        passedTests: 0,
        failedTests: 0,
        counterexamples: []
    };

    console.log('\n=== WEBSHOP BUG CONDITION EXPLORATION TEST ===');
    console.log('CRITICAL: These tests are EXPECTED TO FAIL on unfixed code');
    console.log('Failure confirms that bugs exist and need to be fixed\n');
    
    /**
     * Test 1: Category Navigation Links (Requirements 2.1, 2.2)
     * EXPECTED TO FAIL: Category boxes have no href attributes or click handlers
     */
    console.log('Test 1: Category Navigation Links');
    try {
        const indexHtmlContent = fs.readFileSync(testConfig.files.indexHtml, 'utf8');
        const indexPhpContent = fs.readFileSync(testConfig.files.indexPhp, 'utf8');
        
        // Test category boxes in both index files
        const categoryTests = [
            { category: 'Groenten', expectedLink: 'groenten.php' },
            { category: 'Drinks', expectedLink: 'drinken.php' },
            { category: 'Broods', expectedLink: 'brood.php' },
            { category: 'Spices', expectedLink: 'spices.php' }
        ];
        
        let hasNavigationLinks = true;
        categoryTests.forEach(({ category, expectedLink }) => {
            // Check for href links in HTML
            const htmlLinkRegex = new RegExp(`<a[^>]*href=["']${expectedLink}["'][^>]*>.*?${category}.*?</a>`, 'is');
            const phpLinkRegex = new RegExp(`<a[^>]*href=["']${expectedLink}["'][^>]*>.*?${category}.*?</a>`, 'is');
            
            if (!indexHtmlContent.match(htmlLinkRegex) || !indexPhpContent.match(phpLinkRegex)) {
                hasNavigationLinks = false;
                testResults.counterexamples.push(`Category "${category}" lacks navigation link to ${expectedLink}`);
            }
        });
        
        if (hasNavigationLinks) {
            testResults.passedTests++;
            console.log('  ✓ UNEXPECTED: Navigation links found (should fail on unfixed code)');
        } else {
            testResults.failedTests++;
            console.log('  ✗ EXPECTED FAILURE: Category boxes lack navigation links');
        }
    } catch (error) {
        testResults.failedTests++;
        console.log('  ✗ EXPECTED FAILURE: Error checking navigation links -', error.message);
    }
    
    /**
     * Test 2: File Structure and Naming Consistency (Requirements 2.2, 2.3, 2.4, 2.9)
     * EXPECTED TO FAIL: Files missing, empty, or have naming issues
     */
    console.log('\nTest 2: File Structure and Naming Consistency');
    try {
        const requiredFiles = [
            { file: 'groenten.php', shouldHaveContent: true },
            { file: 'brood.php', shouldExist: true },
            { file: 'spices.php', shouldExist: true },
            { file: 'products.php', shouldHaveContent: true }
        ];
        
        let allFilesValid = true;
        requiredFiles.forEach(({ file, shouldExist = true, shouldHaveContent = false }) => {
            if (!fs.existsSync(file)) {
                allFilesValid = false;
                testResults.counterexamples.push(`File ${file} does not exist`);
            } else if (shouldHaveContent) {
                const content = fs.readFileSync(file, 'utf8').trim();
                if (content.length <= 100) {
                    allFilesValid = false;
                    testResults.counterexamples.push(`File ${file} is empty or has insufficient content`);
                }
            }
        });
        
        // Test cart filename issue - space in filename
        if (!fs.existsSync('inkelwagen.php') || fs.existsSync('inkelwagen .php')) {
            allFilesValid = false;
            testResults.counterexamples.push('Cart file has space in filename "inkelwagen .php" instead of "inkelwagen.php"');
        }
        
        if (allFilesValid) {
            testResults.passedTests++;
            console.log('  ✓ UNEXPECTED: All files exist and have content (should fail on unfixed code)');
        } else {
            testResults.failedTests++;
            console.log('  ✗ EXPECTED FAILURE: Files missing, empty, or have naming issues');
        }
    } catch (error) {
        testResults.failedTests++;
        console.log('  ✗ EXPECTED FAILURE: Error checking file structure -', error.message);
    }
    
    /**
     * Test 3: HTML Structure Validation (Requirements 2.6)
     * EXPECTED TO FAIL: Malformed HTML with unclosed tags
     */
    console.log('\nTest 3: HTML Structure Validation');
    try {
        const filesToCheck = ['Categories.php', 'fruiten.php', 'drinken.php'];
        let allHtmlValid = true;
        
        filesToCheck.forEach(file => {
            if (fs.existsSync(file)) {
                const content = fs.readFileSync(file, 'utf8');
                
                // Check for basic HTML structure
                if (!content.match(/<!DOCTYPE html>/i) || 
                    !content.match(/<html[^>]*>/i) ||
                    !content.match(/<\/html>/i) ||
                    !content.match(/<head[^>]*>/i) ||
                    !content.match(/<\/head>/i) ||
                    !content.match(/<body[^>]*>/i) ||
                    !content.match(/<\/body>/i)) {
                    allHtmlValid = false;
                    testResults.counterexamples.push(`File ${file} has incomplete HTML structure`);
                }
                
                // Check for unclosed tags
                const openDivs = (content.match(/<div[^>]*>/g) || []).length;
                const closeDivs = (content.match(/<\/div>/g) || []).length;
                if (openDivs !== closeDivs) {
                    allHtmlValid = false;
                    testResults.counterexamples.push(`File ${file} has ${openDivs} opening divs but ${closeDivs} closing divs`);
                }
            }
        });
        
        if (allHtmlValid) {
            testResults.passedTests++;
            console.log('  ✓ UNEXPECTED: HTML structure is valid (should fail on unfixed code)');
        } else {
            testResults.failedTests++;
            console.log('  ✗ EXPECTED FAILURE: HTML structure has issues');
        }
    } catch (error) {
        testResults.failedTests++;
        console.log('  ✗ EXPECTED FAILURE: Error checking HTML structure -', error.message);
    }
    
    /**
     * Test 4: Cart Functionality and Error Handling (Requirements 2.5, 2.8)
     * EXPECTED TO FAIL: Cart JavaScript lacks proper error handling
     */
    console.log('\nTest 4: Cart Functionality and Error Handling');
    try {
        const mainJsContent = fs.readFileSync(testConfig.files.mainJs, 'utf8');
        
        // Check for error handling in cart operations
        const hasErrorHandling = mainJsContent.includes('try') && mainJsContent.includes('catch');
        const hasElementExistenceCheck = mainJsContent.includes('querySelector') && 
                                       (mainJsContent.includes('if') || mainJsContent.includes('&&'));
        
        let cartFunctional = hasErrorHandling || hasElementExistenceCheck;
        
        // Check for functional Add to Cart buttons in product pages
        if (fs.existsSync('Categories.php')) {
            const categoriesContent = fs.readFileSync('Categories.php', 'utf8');
            const addToCartRegex = /<button[^>]*class="[^"]*add-to-cart[^"]*"[^>]*>|<button[^>]*onclick="[^"]*addToCart[^"]*"/;
            
            if (!categoriesContent.match(addToCartRegex)) {
                cartFunctional = false;
                testResults.counterexamples.push('Categories.php lacks functional Add to Cart buttons');
            }
        }
        
        if (!hasErrorHandling) {
            testResults.counterexamples.push('Cart JavaScript lacks proper error handling (try/catch)');
        }
        
        if (cartFunctional) {
            testResults.passedTests++;
            console.log('  ✓ UNEXPECTED: Cart functionality is robust (should fail on unfixed code)');
        } else {
            testResults.failedTests++;
            console.log('  ✗ EXPECTED FAILURE: Cart operations lack error handling and functional buttons');
        }
    } catch (error) {
        testResults.failedTests++;
        console.log('  ✗ EXPECTED FAILURE: Error checking cart functionality -', error.message);
    }
    
    /**
     * Test 5: Database Query Correctness (Requirements 2.7)
     * EXPECTED TO FAIL: Uses incorrect column name "catogorie" instead of "category"
     */
    console.log('\nTest 5: Database Query Correctness');
    try {
        const filesToCheck = ['fruiten.php', 'drinken.php'];
        let dbQueriesCorrect = true;
        
        filesToCheck.forEach(file => {
            if (fs.existsSync(file)) {
                const content = fs.readFileSync(file, 'utf8');
                
                if (content.includes('catogorie')) {
                    dbQueriesCorrect = false;
                    testResults.counterexamples.push(`File ${file} uses incorrect column name "catogorie" instead of "category"`);
                }
            }
        });
        
        if (dbQueriesCorrect) {
            testResults.passedTests++;
            console.log('  ✓ UNEXPECTED: Database queries use correct column names (should fail on unfixed code)');
        } else {
            testResults.failedTests++;
            console.log('  ✗ EXPECTED FAILURE: Database queries use incorrect column name "catogorie"');
        }
    } catch (error) {
        testResults.failedTests++;
        console.log('  ✗ EXPECTED FAILURE: Error checking database queries -', error.message);
    }
    
    /**
     * Test 6: Professional Styling and Responsive Design (Requirements 2.6, 2.10)
     * EXPECTED TO FAIL: Inconsistent styling and poor mobile responsiveness
     */
    console.log('\nTest 6: Professional Styling and Responsive Design');
    try {
        const cssContent = fs.readFileSync(testConfig.files.styleCss, 'utf8');
        
        // Check for comprehensive responsive design
        const hasProperMediaQueries = cssContent.includes('@media') && 
                                    cssContent.includes('max-width') &&
                                    cssContent.includes('min-width');
        
        // Check for modern CSS features
        const hasFlexbox = cssContent.includes('display: flex') || cssContent.includes('display:flex');
        const hasGrid = cssContent.includes('display: grid') || cssContent.includes('display:grid');
        const hasCustomProperties = cssContent.includes('--') && cssContent.includes('var(');
        
        // Check for professional color system
        const colorVariables = (cssContent.match(/--[\w-]+:/g) || []).length;
        const hasConsistentColors = cssContent.includes(':root') && colorVariables >= 5;
        
        // Check for modern UI components
        const hasModernButtons = cssContent.includes('transition') && 
                               cssContent.includes('border-radius') &&
                               cssContent.includes('hover');
        
        let stylingProfessional = hasProperMediaQueries && hasFlexbox && hasGrid && 
                                hasCustomProperties && hasConsistentColors && hasModernButtons;
        
        if (!hasProperMediaQueries) {
            testResults.counterexamples.push('CSS lacks comprehensive responsive media queries');
        }
        if (!hasGrid) {
            testResults.counterexamples.push('CSS lacks modern CSS Grid layout system');
        }
        if (colorVariables < 10) {
            testResults.counterexamples.push(`CSS has only ${colorVariables} color variables, needs comprehensive color system`);
        }
        
        if (stylingProfessional) {
            testResults.passedTests++;
            console.log('  ✓ UNEXPECTED: CSS has comprehensive professional styling (should fail on unfixed code)');
        } else {
            testResults.failedTests++;
            console.log('  ✗ EXPECTED FAILURE: CSS lacks comprehensive professional styling system');
        }
    } catch (error) {
        testResults.failedTests++;
        console.log('  ✗ EXPECTED FAILURE: Error checking CSS styling -', error.message);
    }
    
    /**
     * Test 7: Mobile Responsiveness Validation (Requirements 2.6)
     * EXPECTED TO FAIL: Poor mobile layout and responsiveness
     */
    console.log('\nTest 7: Mobile Responsiveness Validation');
    try {
        const cssContent = fs.readFileSync(testConfig.files.styleCss, 'utf8');
        
        // Check for comprehensive mobile-first approach
        const mobileQueries = cssContent.match(/@media[^{]*\([^)]*max-width[^)]*\)[^{]*{/g) || [];
        const tabletQueries = cssContent.match(/@media[^{]*\([^)]*min-width[^)]*\)[^{]*{/g) || [];
        
        // Check for mobile navigation
        const hasMobileNav = cssContent.includes('menu-icon') && 
                           cssContent.includes('display: none') &&
                           cssContent.includes('display: block');
        
        let mobileResponsive = mobileQueries.length >= 2 && tabletQueries.length >= 1 && hasMobileNav;
        
        if (mobileQueries.length < 2) {
            testResults.counterexamples.push(`Only ${mobileQueries.length} mobile breakpoints found, needs at least 2`);
        }
        if (tabletQueries.length < 1) {
            testResults.counterexamples.push('No tablet breakpoints found');
        }
        if (!hasMobileNav) {
            testResults.counterexamples.push('Mobile navigation system is incomplete');
        }
        
        if (mobileResponsive) {
            testResults.passedTests++;
            console.log('  ✓ UNEXPECTED: Mobile responsiveness is comprehensive (should fail on unfixed code)');
        } else {
            testResults.failedTests++;
            console.log('  ✗ EXPECTED FAILURE: Mobile responsiveness is insufficient');
        }
    } catch (error) {
        testResults.failedTests++;
        console.log('  ✗ EXPECTED FAILURE: Error checking mobile responsiveness -', error.message);
    }
    
    /**
     * Test 8: Integration and Cross-Page Consistency (Requirements 2.10)
     * EXPECTED TO FAIL: Inconsistent code structure and styling across pages
     */
    console.log('\nTest 8: Integration and Cross-Page Consistency');
    try {
        const phpFiles = ['index.php', 'Categories.php', 'fruiten.php', 'drinken.php'];
        const existingFiles = phpFiles.filter(file => fs.existsSync(file));
        
        // Check for consistent database connection patterns
        let dbConnectionPatterns = [];
        existingFiles.forEach(file => {
            const content = fs.readFileSync(file, 'utf8');
            const hasDbConnection = content.includes('PDO') && content.includes('dbConnection');
            dbConnectionPatterns.push(hasDbConnection);
        });
        
        const allHaveConsistentDb = dbConnectionPatterns.every(pattern => pattern === dbConnectionPatterns[0]);
        
        // Check for consistent styling approach
        let stylingConsistent = true;
        existingFiles.forEach(file => {
            const content = fs.readFileSync(file, 'utf8');
            if (content.includes('<link')) {
                if (!content.includes('style.css') || !content.includes('bootstrap')) {
                    stylingConsistent = false;
                    testResults.counterexamples.push(`File ${file} has inconsistent CSS includes`);
                }
            }
        });
        
        let crossPageConsistent = allHaveConsistentDb && stylingConsistent;
        
        if (!allHaveConsistentDb) {
            testResults.counterexamples.push('Database connection patterns are inconsistent across pages');
        }
        
        if (crossPageConsistent) {
            testResults.passedTests++;
            console.log('  ✓ UNEXPECTED: Cross-page consistency is good (should fail on unfixed code)');
        } else {
            testResults.failedTests++;
            console.log('  ✗ EXPECTED FAILURE: Inconsistent code structure across pages');
        }
    } catch (error) {
        testResults.failedTests++;
        console.log('  ✗ EXPECTED FAILURE: Error checking cross-page consistency -', error.message);
    }

    return testResults;
}

/**
 * Test Runner Function
 * This function will execute all tests and document the counterexamples found
 */
function runBugExplorationTests() {
    const testResults = runBugConditionTests();
    
    console.log('\n=== TEST RESULTS SUMMARY ===');
    console.log(`Total Tests: ${testResults.totalTests}`);
    console.log(`Passed Tests: ${testResults.passedTests} (unexpected on unfixed code)`);
    console.log(`Failed Tests: ${testResults.failedTests} (expected on unfixed code)`);
    
    if (testResults.counterexamples.length > 0) {
        console.log('\nCOUNTEREXAMPLES FOUND (confirming bugs exist):');
        testResults.counterexamples.forEach((example, index) => {
            console.log(`${index + 1}. ${example}`);
        });
    }
    
    console.log('\n✓ BUG EXPLORATION COMPLETE');
    if (testResults.failedTests > 0) {
        console.log('✓ Expected failures documented - bugs confirmed to exist');
        console.log('✓ Root cause analysis validated');
    } else {
        console.log('⚠ WARNING: No failures found - code may already be fixed or tests need adjustment');
    }
    console.log('\nNext step: Implement fixes to address these issues');
    
    return testResults;
}

// Export for use in test runners
module.exports = {
    runBugExplorationTests,
    testConfig
};

// If run directly, execute the exploration
if (require.main === module) {
    runBugExplorationTests();
}