### Source code for the AF Talent Marketplace
[![Build Status](https://travis-ci.org/jlepird/next-gen-assignments.png)](https://travis-ci.org/jlepird/next-gen-assignments) [![codecov](https://codecov.io/gh/jlepird/next-gen-assignments/branch/master/graph/badge.svg)](https://codecov.io/gh/jlepird/next-gen-assignments)

This repository contains all of the source code for the Air Force Talent Marketplace test. It is a prototype proof-of-concept and is not intended for production use at this time.

#### What are we testing?
The National Residency Matching Program [NRMP](http://www.nrmp.org/) is the process by which graduating medical students are assigned to their initial medical residencies. It assigns over 30,000 medical students annually, and its methodology was awarded a [Nobel Prize](http://www.nrmp.org/wp-content/uploads/2013/08/The-Sveriges-Riksbank-Prize-in-Economic-Sciences-in-Memory-of-Alfred-Nobel1.pdf) in 2012. Here's how it works: 

* Graduating medical students submit prioritized lists of the hospitals they'd like to work at.
* Hospitals submit prioritized lists of the graduating medical students they'd like to have as residents.
* The NRMP collects all preference lists, and runs the [Deferred Acceptance Algorithm](https://en.wikipedia.org/wiki/Stable_marriage_problem#Solution) to assign medical students to hospitals. The NRMP's implementation of the algorithm takes under five minutes to run.

Cross applying this approach shows promise to assigning military personnel for their Permanent Changes of Station (PCSs). Airmen would prioritize open billets they'd like to fill, gaining commanders would prioritize Airmen on the Vulnerable to Move List (VML), and the Air Force could use the exact same algorithm to determine assignments. This mechanism would give Airmen and gaining commanders more explicit input into the assignments process, while maintaining centralized oversight, auditability, and transparency.

#### Can I help?
Yes! If you find a bug or have a suggestion for a feature, please let us know via email or through this page's [issue tracker](https://github.com/jlepird/next-gen-assignments/issues). 

