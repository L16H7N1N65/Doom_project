# L16H7N1N65.github.io

## Doom Project

### Overview
Serval Project is a PHP Object-Oriented Programming (POO) application offering a first-person view experience, reminiscent of the iconic game Doom from the 1990s. It involves HTML, CSS, PHP, and MySQL technologies.

### Usage
For optimal experience, it is recommended to use the project with the following specifications:
- Screen resolution: 1024 x 1366 (iPad Pro dimensions)

### Part 1: Project Description
Serval Project allows users to navigate through various environments from a first-person perspective. The application relies on PHP classes (`FirstPersonView`, `FirstPersonText`) to simulate the immersive experience. Key features include:

#### Layout
The interface is divided into three sections:
- First-person view
- Movement control area
- Database integration for storing map coordinates, images, and texts

#### Classes
- **DataBase Class**: Manages database connections.
- **BaseClass**: Base class for creating a first-person avatar and handling movements and image display.
- **FirstPersonView**: Specializes BaseClass by managing images and compass display.
- **FirstPersonText**: Specializes BaseClass by managing text display.

### Part 2: Interactivity
In this section, the project enhances interactivity by adding features for interacting with the environment. Users can "take" items and "use" them at specific locations. The X button becomes active when an action is possible.

#### Database Modification
Two tables are added: `actions` and `items`, allowing for a richer interactive experience.

#### Class
- **FirstPersonAction**: Specializes `BaseClass` by managing actions with the environment.

### Methodology
1. Design the Conceptual Data Model (MCD) for the database tables.
2. Develop database classes and implement an autoloader function.
3. Code the layout for the interface and integrate database functionality.
4. Develop specialized classes for managing first-person view, text, and actions.
5. Implement code factorization following the DRY principle.

### Installation
1. Clone the repository to your local machine.
2. Import the provided SQL file to set up the database.
3. Configure database connection settings in `database.php`.
4. Launch the project using a PHP server.

### Conclusion
Serval Project offers a nostalgic journey reminiscent of classic first-person shooter games like Doom, while also showcasing modern web development techniques. With immersive visuals and interactive features, it promises an engaging user experience.
